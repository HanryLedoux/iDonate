import { test, expect } from '@playwright/test';

test.describe('Site basic flows', () => {
  test('home and navigation links work', async ({ page }) => {
    await page.goto('/');
    await expect(page).toHaveTitle(/iDonate|Laravel|Plataforma/);

    // Navigate directly to events and companies to validate pages load
    await page.goto('/events');
    await page.waitForURL(/(\/events|\/login)/);
    if (page.url().includes('/login')) {
      await expect(page.locator('form')).toBeVisible();
    } else {
      await expect(page.locator('h1, h2').first()).toBeVisible({ timeout: 7000 });
    }

    await page.goto('/companies');
    await page.waitForURL(/(\/companies|\/login)/);
    if (page.url().includes('/login')) {
      await expect(page.locator('form')).toBeVisible();
    } else {
      await expect(page.locator('h1, h2').first()).toBeVisible({ timeout: 7000 });
    }
  });

  test('register and login flow (receptor)', async ({ page }) => {
    // go to register
    await page.goto('/register');
    const unique = Date.now();
    const email = `e2e+${unique}@example.com`;

    await page.fill('input[name="name"]', 'E2E Receptor');
    await page.fill('input[name="email"]', email);
    // role select may be a radio/select; try select if exists
    const roleSelect = page.locator('select[name="role"]');
    if (await roleSelect.count()) {
      await roleSelect.selectOption('receptor');
    } else {
      // try radio
      const roleRadio = page.getByRole('radio', { name: /receptor/i });
      if (await roleRadio.count()) await roleRadio.first().check();
    }

    await page.fill('input[name="password"]', 'password');
    await page.fill('input[name="password_confirmation"]', 'password');
    await page.click('button[type="submit"]');

    // wait for navigation or presence of user name in header
    await page.waitForTimeout(1000);
    const userName = page.locator('text=E2E Receptor').first();
    await expect(userName).toBeVisible({ timeout: 7000 });
  });

  test('dashboard items navigate to details', async ({ page }) => {
    // register receptor and verify food detail navigation from dashboard
    await page.goto('/register');
    const unique = Date.now();
    const email = `e2e+${unique}@example.com`;

    await page.fill('input[name="name"]', 'E2E Receptor 2');
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

    await page.waitForTimeout(1000);
    await page.goto('/dashboard');

    // click first food card if present
    const firstFood = page.locator('a[href^="/food-items/"]').first();
    if (await firstFood.count()) {
      await firstFood.click();
      await page.waitForURL(/\/food-items\//);
      await expect(page.url()).toMatch(/\/food-items\//);
    } else {
      // no food listed; ensure dashboard loaded
      await expect(page.locator('text=Alimentos Disponíveis').first()).toBeVisible();
    }

    // register a volunteer to check event navigation
    await page.goto('/register');
    const unique2 = Date.now() + 1;
    const email2 = `e2e+vol${unique2}@example.com`;
    await page.fill('input[name="name"]', 'E2E Volunteer');
    await page.fill('input[name="email"]', email2);
    if (await roleSelect.count()) {
      await roleSelect.selectOption('voluntario');
    } else {
      const roleRadio = page.getByRole('radio', { name: /voluntari/i });
      if (await roleRadio.count()) await roleRadio.first().check();
    }
    await page.fill('input[name="password"]', 'password');
    await page.fill('input[name="password_confirmation"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForTimeout(1000);
    await page.goto('/dashboard');

    const firstEvent = page.locator('a[href^="/events/"]').first();
    if (await firstEvent.count()) {
      await firstEvent.click();
      await page.waitForURL(/\/events\//);
      await expect(page.url()).toMatch(/\/events\//);
    } else {
      await expect(page.locator('text=Próximos Eventos').first()).toBeVisible();
    }
  });
});
