# Test Upsun Add-on Repository

## Purpose

This repository serves as an authoritative source of working Upsun configurations for testing the [ddev-upsun add-on](https://github.com/rfay/ddev-upsun). Each branch contains verified, deployable configurations for different project types.

## About Upsun

Upsun is a Platform-as-a-Service (PaaS) that allows you to develop, deploy, and scale applications in the cloud. 

- **Documentation**: https://docs.upsun.com/
- **Getting Started**: https://docs.upsun.com/get-started/
- **Console**: https://console.upsun.com/

## Using the Upsun Command

### Installation
Follow the installation guide: https://docs.upsun.com/administration/cli/install.html

### Getting Help
- `upsun list` - Shows all available commands
- `upsun help [command]` - Get help for a specific command
- `upsun --help` - General help and global options

### Common Commands
- `upsun environment:url` - Get the URL of your deployed site
- `upsun activity:list` - View deployment history and status
- `upsun activity:log [id]` - View logs for a specific deployment
- `upsun environment:list` - List all environments
- `upsun environment:ssh` - SSH into your environment

### Project Structure
- **Main branch**: Basic HTML/Markdown static site
- **Future branches**: Framework-specific configurations (Drupal, Laravel, etc.)

## Deployment Process

1. Push code to the repository
2. Upsun automatically builds and deploys based on `.upsun/config.yaml`
3. Check deployment status with `upsun activity:list`
4. Get the live URL with `upsun environment:url`