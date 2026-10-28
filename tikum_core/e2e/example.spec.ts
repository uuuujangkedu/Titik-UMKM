import { test, expect } from '@playwright/test';

const publicPaths = [
  '/',
  '/login',
  '/register',
  '/#tentang-kami',
  '/gabung/investor',
  '/gabung/umkm',
  '/usulkan-ruko',
  '/#tutorial',
  '/#bantuan',
  '/#kontak',
  '/formulir/investor',
  '/formulir/umkm',
];

test.describe('Halaman publik', () => {
  for (const path of publicPaths) {
    test(`${path} bisa dibuka tanpa error server`, async ({ page }) => {
      const response = await page.goto(path);

      expect(response?.status(), `HTTP status untuk ${path}`).toBeLessThan(500);
      await expect(page.locator('body')).not.toBeEmpty();
    });
  }

  test('login menampilkan form masuk', async ({ page }) => {
    await page.goto('/login');
    await expect(page.getByRole('heading', { name: 'Masuk ke akun' })).toBeVisible();
  });
});

const dashboardTabs = [
  'beranda', 'portofolio', 'pesan', 'proposal', 'ruko', 'keuangan',
  'kalkulator', 'komunitas', 'inbox', 'produk', 'bantuan',
];

test.describe('Dashboard investor', () => {
  test('tab dashboard mengharuskan autentikasi', async ({ page }) => {
    for (const tab of dashboardTabs) {
      const response = await page.goto(`/dashboard?tab=${tab}`);

      expect(response?.status(), `HTTP status untuk tab ${tab}`).toBeLessThan(500);
      await expect(page).toHaveURL(/login|dashboard/);
    }
  });
});
