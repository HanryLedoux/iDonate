describe('Fluxo de autenticação e cadastro', () => {
  beforeEach(() => {
    cy.clearCookies();
    cy.clearLocalStorage();
  });

  it('autentica com usuário e senha válidos', () => {
    cy.visit('/login');

    cy.get('input[name="email"]').type('kauanzingameplays@gmail.com');
    cy.get('input[name="password"]').type('@Aa123456');
    cy.contains('button', 'Entrar').click();

    cy.location('pathname', { timeout: 10000 }).should('eq', '/dashboard');
    cy.contains('Olá').should('be.visible');
  });

  it('não cadastra com e-mail vazio', () => {
    cy.visit('/register');

    cy.get('input[name="name"]').type('Gabriel Morales');
    cy.get('input[name="email"]').clear();
    cy.get('input[name="password"]').type('@Aa123456');
    cy.get('input[name="password_confirmation"]').type('@Aa123456');
    cy.get('select[name="role"]').select('voluntario');
    cy.contains('button', 'Registrar').click();

    cy.contains('O campo de e-mail é obrigatório').should('be.visible');
    cy.location('pathname').should('eq', '/register');
  });

  it('não cadastra com nome vazio', () => {
    cy.visit('/register');

    cy.get('input[name="name"]').clear();
    cy.get('input[name="email"]').type('kauanzingameplays@gmail.com');
    cy.get('input[name="password"]').type('@Aa123456');
    cy.get('input[name="password_confirmation"]').type('@Aa123456');
    cy.get('select[name="role"]').select('voluntario');
    cy.contains('button', 'Registrar').click();

    cy.contains('O campo de nome é obrigatório').should('be.visible');
    cy.location('pathname').should('eq', '/register');
  });

  it('não cadastra quando as senhas são diferentes', () => {
    cy.visit('/register');

    cy.get('input[name="name"]').type('Gabriel Morales');
    cy.get('input[name="email"]').type('kauanzingameplays@gmail.com');
    cy.get('input[name="password"]').type('@Aa123456');
    cy.get('input[name="password_confirmation"]').type('@Aa123457');
    cy.get('select[name="role"]').select('voluntario');
    cy.contains('button', 'Registrar').click();

    cy.contains('As senhas não coincidem').should('be.visible');
    cy.location('pathname').should('eq', '/register');
  });

  it('não recupera senha com e-mail inexistente', () => {
    cy.visit('/forgot-password');

    cy.get('input[name="email"]').type('emailnaousadoateagora@gmail.com');
    cy.contains('button', 'Email Password Reset Link').click();

    cy.contains("We can't find a user with that email address.", { matchCase: false }).should('be.visible');
  });

  it('recupera senha com e-mail existente', () => {
    cy.visit('/forgot-password');

    cy.get('input[name="email"]').type('kauanzingameplays@gmail.com');
    cy.contains('button', 'Email Password Reset Link').click();

    cy.contains('sucesso|enviado|instruções', { matchCase: false }).should('be.visible');
  });
});
