import module$1 from 'module';

const require$1 = module$1.createRequire(import.meta.url);
const cypress = require$1('./cypress');
const defineConfig = cypress.defineConfig;
const defineComponentFramework = cypress.defineComponentFramework;
const run = cypress.run;
const open = cypress.open;
const cli = cypress.cli;

export { cli, cypress as default, defineComponentFramework, defineConfig, open, run };
