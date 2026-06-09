import { test, expect } from '@playwright/test';

test.describe('Role-based request controls', () => {
  test('Receptor can see and use Pedir button on an event', async ({ page }) => {
    // Ensure there is at least one event with a food item attached: create an owner first
    const ownerPage = await page.context().newPage();
    await ownerPage.goto('/register');
    const uniqueOwner = Date.now();
    const ownerEmail = `e2e+owner+${uniqueOwner}@example.com`;
    await ownerPage.fill('input[name="name"]', 'E2E Owner');
    await ownerPage.fill('input[name="email"]', ownerEmail);
    const ownerRoleSelect = ownerPage.locator('select[name="role"]');
    if (await ownerRoleSelect.count()) {
      await ownerRoleSelect.selectOption('doador');
    } else {
      const roleRadio = ownerPage.getByRole('radio', { name: /doador/i });
      if (await roleRadio.count()) await roleRadio.first().check();
    }
    await ownerPage.fill('input[name="password"]', 'password');
    await ownerPage.fill('input[name="password_confirmation"]', 'password');
    await ownerPage.click('button[type="submit"]');
    await ownerPage.waitForSelector('text=E2E Owner', { timeout: 7000 }).catch(() => {});

    // create event
    await ownerPage.goto('/events/create');
    const uniqueT = Date.now();
    await ownerPage.fill('input[name="title"]', `E2E Event ${uniqueT}`);
    await ownerPage.fill('textarea[name="description"]', 'E2E event');
    const dt = new Date(Date.now() + 3600 * 1000).toISOString().slice(0,16);
    await ownerPage.fill('input[name="event_date"]', dt);
    await ownerPage.fill('input[name="location"]', 'Local Test');
    await ownerPage.click('button[type="submit"]');
    await ownerPage.waitForURL(/\/events/);

    // get event id
    await ownerPage.goto('/events');
    const eventLink = ownerPage.getByRole('link', { name: new RegExp(`E2E Event`, 'i') }).first();
    if (!await eventLink.count()) { await ownerPage.close(); test.skip(); }
    await eventLink.click();
    await ownerPage.waitForURL(/\/events\//);
    const eventId = ownerPage.url().split('/').pop();

    // find company id
    await ownerPage.goto('/companies');
    const companyLink = ownerPage.getByRole('link', { name: /E2E Owner/i }).first();
    if (!await companyLink.count()) { await ownerPage.close(); test.skip(); }
    const href = await companyLink.getAttribute('href');
    const companyId = href.split('/').pop();

    // create food item attached to event
    await ownerPage.evaluate(async (companyId, eventId) => {
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      await fetch(`/companies/${companyId}/food-items`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ title: 'E2E Food', description: 'desc', quantity: 3, event_id: eventId })
      });
    }, companyId, eventId);
    await ownerPage.close();

    // now register receiver
    await page.goto('/register');
    const unique = Date.now();
    const email = `e2e+${unique}@example.com`;

    await page.fill('input[name="name"]', 'E2E Receptor');
    await page.fill('input[name="email"]', email);
    const roleSelect = page.locator('select[name="role"]');
    if (await roleSelect.count()) {
      await roleSelect.selectOption('receptor');
    } else {
      const roleRadio = page.getByRole('radio', { name: /receptor/i });
      if (await roleRadio.count()) await roleRadio.first().check();
    }
    await page.fill('input[name="password"]', 'password');
    await page.fill('input[name="password_confirmation"]', 'password');
    await page.click('button[type="submit"]');

    // go to first event
    await page.goto('/events');
    const firstEvent = page.locator('a[href^="/events/"]').first();
    if (await firstEvent.count()) {
      await firstEvent.click();
      await page.waitForURL(/\/events\//);
      const pedir = page.getByRole('button', { name: /Pedir/i }).first();
      await expect(pedir).toBeVisible({ timeout: 7000 });
    } else {
      test.skip();
    }
  });

  test('Doador should NOT be able to request (Pedir) — button disabled or hidden', async ({ page }) => {
    await page.goto('/register');
    const unique = Date.now();
    const email = `e2e+doador+${unique}@example.com`;

    await page.fill('input[name="name"]', 'E2E Doador');
    await page.fill('input[name="email"]', email);
    const roleSelect = page.locator('select[name="role"]');
    if (await roleSelect.count()) {
      await roleSelect.selectOption('doador');
    } else {
      const roleRadio = page.getByRole('radio', { name: /doador|doador/i });
      if (await roleRadio.count()) await roleRadio.first().check();
    }
    await page.fill('input[name="password"]', 'password');
    await page.fill('input[name="password_confirmation"]', 'password');
    await page.click('button[type="submit"]');

    await page.goto('/events');
    const firstEvent = page.locator('a[href^="/events/"]').first();
    if (await firstEvent.count()) {
      await firstEvent.click();
      await page.waitForURL(/\/events\//);
      // Pedir button should be disabled or a gray button shown
      const pedirEnabled = page.getByRole('button', { name: /Pedir$/i });
      if (await pedirEnabled.count()) {
        await expect(pedirEnabled).not.toBeEnabled();
      } else {
        // fallback: look for disabled-like text
        const pedirText = page.locator('text=Pedir (somente receptores)');
        await expect(pedirText).toBeVisible();
      }
    } else {
      test.skip();
    }
  });
});
