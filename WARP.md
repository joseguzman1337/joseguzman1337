# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Repository Overview

This is a GitHub profile repository (joseguzman1337/joseguzman1337) that serves as the user's GitHub profile README. The repository focuses on cybersecurity, bug bounty hunting, and ethical hacking practices.

## Repository Structure

- **README.md** - Profile README displayed on GitHub profile page
- **aa.png** - Profile image or logo
- **.github/workflows/** - GitHub Actions workflows for security scanning
- **LICENSE** - GPL-3.0 license file

## Security and Quality Tooling

The repository implements multiple layers of security scanning and quality assurance:

### Pre-commit Hooks
```bash
# Install pre-commit hooks
pre-commit install

# Run hooks manually
pre-commit run --all-files
```

Active hooks:
- **Gitleaks** (v8.16.3) - Secret detection and prevention
- **Standard hooks** - End-of-file fixing and trailing whitespace removal

### GitHub Actions Workflows

**Dependency Review** (`.github/workflows/dependency-review.yml`)
- Automatically scans PRs for vulnerable dependencies
- Blocks merging of PRs with known vulnerabilities
- Uses hardened runner environment

**Scorecard Security Analysis** (`.github/workflows/scorecards.yml`)
- Weekly security scorecard analysis (Tuesdays at 7:20 AM)
- OSSF (Open Source Security Foundation) scorecard evaluation
- Results uploaded to GitHub Security tab

### WhiteSource Security Scanning
Configuration in `.whitesource`:
- Vulnerability check level: failure on any severity
- Minimum severity threshold: LOW
- Display mode: diff-based reporting

## Development Workflow

Since this is primarily a profile repository:

1. **Content Updates**: Edit README.md for profile information
2. **Security First**: All commits are automatically scanned for secrets
3. **Quality Assurance**: Pre-commit hooks ensure clean commits
4. **Automated Security**: Weekly security assessments via GitHub Actions

## Key Security Features

- **Secret Prevention**: Gitleaks integration prevents accidental secret commits
- **Supply Chain Security**: Dependency review prevents vulnerable package introduction
- **Continuous Monitoring**: Regular security scorecard assessments
- **Hardened CI/CD**: Security-focused GitHub Actions configuration

## Common Commands

```bash
# Check for secrets before commit
pre-commit run gitleaks

# Run all pre-commit checks
pre-commit run --all-files

# View git log with security focus
git log --oneline --grep="security\|fix\|vuln"

# Check repository security status
git log --grep="Scorecard\|Dependency"
```

## Branch Strategy

- **Main branch** - Protected with security checks
- **Pull Requests** - Required for dependency review
- **Security scanning** - Applied to all branches

This repository prioritizes security and quality over development velocity, making it ideal for cybersecurity-focused content and profile maintenance.
