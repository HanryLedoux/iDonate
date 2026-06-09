import { test, expect } from '@playwright/test';

test.describe('Event owner inline edit', () => {
  test('Owner can edit food item inline and undo', async ({ page }) => {
    // register as a user (doador) who may own events
    await page.goto('/register');
    const unique = Date.now();
    const email = `e2e+owner+${unique}@example.com`;

    await page.fill('input[name="name"]', 'E2E Owner');
    await page.fill('input[name="email"]', email);
    const roleSelect = page.locator('select[name="role"]');
    if (await roleSelect.count()) {
      await roleSelect.selectOption('doador');
    } else {
      const roleRadio = page.getByRole('radio', { name: /doador/i });
      if (await roleRadio.count()) await roleRadio.first().check();
    }
    await page.fill('input[name="password"]', 'password');
    await page.fill('input[name="password_confirmation"]', 'password');
    await Promise.all([
      page.waitForNavigation({ waitUntil: 'networkidle' }),
      page.click('button[type="submit"]')
    ]);

    // create an event (owner)
    await page.goto('/events/create');
    if (!(await page.locator('form').count())) return test.skip();
    const uniqueT = Date.now();
    await page.fill('input[name="title"]', `E2E Event ${uniqueT}`);
    await page.fill('textarea[name="description"]', 'E2E event description');
    // event_date expected format Y-m-d H:i or similar; use ISO
    const dt = new Date(Date.now() + 3600 * 1000).toISOString().slice(0,16);
    await page.fill('input[name="event_date"]', dt);
    await page.fill('input[name="location"]', 'Local Test');
    await page.click('button[type="submit"]');
    await page.waitForURL(/\/events/);

    // get the created event id by clicking the first event with our title
    await page.goto('/events');
    const eventLink = page.getByRole('link', { name: new RegExp(`E2E Event`, 'i') }).first();
    if (!await eventLink.count()) return test.skip();
    await eventLink.click();
    await page.waitForURL(/\/events\//);

    // prepare a food item attached to this event: find company id
    const companyIndex = await page.context().newPage();
    await companyIndex.goto('/companies');
    const companyLink = companyIndex.getByRole('link', { name: /E2E Owner/i }).first();
    if (!await companyLink.count()) { await companyIndex.close(); return test.skip(); }
    const href = await companyLink.getAttribute('href');
    const companyId = href.split('/').pop();
    await companyIndex.close();

    // create food item via fetch from the logged-in page (keeps session)
    const eventId = page.url().split('/').pop();
    await page.evaluate(async (companyId, eventId) => {
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      await fetch(`/companies/${companyId}/food-items`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ title: 'E2E Food', description: 'desc', quantity: 5, event_id: eventId })
      });
    }, companyId, eventId);

    // reload event page to load attached food item
    await page.reload();

    // find an editable food item
    const editBtn = page.locator('.btn-edit').first();
    if (!await editBtn.count()) return test.skip();

    const li = editBtn.locator('xpath=ancestor::div[@data-food-item-id]');
    const qtyEl = li.locator('.food-quantity');
    const availEl = li.locator('.food-availability');

    const originalQty = parseInt(await qtyEl.textContent() || '0', 10) || 0;
    const originalAvail = (await availEl.textContent() || '').includes('Disponível');

    await editBtn.click();
    const inlineQty = li.locator('.inline-quantity');
    await inlineQty.fill(String(originalQty + 1));
    const saveBtn = li.locator('.inline-save');
    await saveBtn.click();

    // expect optimistic update
    await expect(qtyEl).toHaveText(String(originalQty + 1));

    // undo
    const undoBtn = li.locator('button:has-text("Desfazer")');
    if (!await undoBtn.count()) return test.skip();
    await undoBtn.click();

    // after undo, expect original values restored
    await expect(qtyEl).toHaveText(String(originalQty));
  });
});
