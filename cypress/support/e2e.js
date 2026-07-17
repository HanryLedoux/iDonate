// Disable uncaught exception handler if needed
Cypress.on('uncaught:exception', (err, runnable) => {
  // Return false to prevent Cypress from failing the test
  // when Laravel throws an error
  return false;
});
