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
- `upsun activity:log [id]` - View detailed logs for a specific deployment (essential for debugging)
- `upsun activity:log` - View logs for the most recent activity
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

## Debugging Failed Deployments

When deployments fail, use these commands to troubleshoot:

1. `upsun activity:list` - Find the failed activity ID
2. `upsun activity:log [failed-activity-id]` - View detailed error logs
3. Common issues:
   - Configuration syntax errors in `.upsun/config.yaml`
   - Invalid root paths (use actual directory names, not `.` or `/`)
   - Missing required directories or files
   - Invalid application types or versions

Example debugging workflow:
```bash
$ upsun activity:list
# Find the failed activity ID (e.g., abc123def)
$ upsun activity:log abc123def
# Review the error messages to fix configuration issues
```

## Lessons Learned from This Project Setup

### Configuration Issues Encountered

1. **No "static" application type**: There's no `type: "static"` - you must use a runtime like `nodejs:22`, `php:8.3`, etc.

2. **Root path restrictions**:
   - Cannot use `"/"` (must not start with slash)
   - Cannot use `"."` (cannot include empty parts, '.', or '..')
   - Must specify an actual directory name like `"public"`

3. **Disk configuration not supported**: The `disk:` key is not supported in Upsun configurations (unlike Platform.sh)

### Content Serving Issues

4. **Markdown files download instead of render**: By default, `.md` files are served with `content-type: application/octet-stream`, causing browsers to download them instead of displaying them.

5. **Solutions for serving markdown**:
   - **Option A**: Create `index.html` files for proper web serving (recommended)
   - **Option B**: Use custom headers in `.upsun/config.yaml`:
     ```yaml
     web:
       locations:
         "/":
           rules:
             \.md$:
               headers:
                 Content-Type: "text/markdown; charset=UTF-8"
     ```

### Working Configuration Example

Final working configuration for static site:
```yaml
applications:
  app:
    source:
      root: "/"
    type: "nodejs:22"
    web:
      locations:
        "/":
          root: "public"
          index:
            - "index.html"
            - "README.md"
          scripts: false
          allow: true

routes:
  "https://{default}/": 
    type: upstream
    upstream: "app:http"
```

### Deployment Verification

Always verify deployments work properly:
```bash
# Check if deployment succeeded
upsun activity:list

# Get the URL
upsun environment:url

# Test content type (should be text/html, not application/octet-stream)
curl -I $(upsun environment:url)
```