# Green Security - WordPress Security Plugin

A comprehensive WordPress security plugin that monitors your website for suspicious activities.

## Features

### 🔍 File Scanner
- Quick scan for PHP files in uploads directory
- Full scan for suspicious code patterns (eval, base64_decode, shell_exec, etc.)
- Detection of recently modified files

### 📦 Plugin Monitoring
- Real-time alerts when new plugins are activated
- Track plugin installation and deactivation history
- Email notifications for plugin changes

### 👤 User Monitoring
- Alert when new users are registered
- Monitor user role changes
- Track user registration history

### 📧 Email Alerts
- Configurable email notifications
- Alert on file scan results
- Alert on new plugin activations
- Alert on new user registrations
- Alert on user role changes

## Installation

1. Upload the `green-security` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Green Security menu to configure settings

## Configuration

1. Navigate to Green Security → Settings
2. Configure your preferred notification settings
3. Enter admin email for alerts
4. Enable/disable specific monitoring features

## Usage

### Dashboard
View overall security status and recent activities.

### File Scanner
- Quick Scan: Fast scan for obvious threats
- Full Scan: Comprehensive scan for suspicious code

### Plugin Monitor
View all plugin activation/deactivation history.

### User Monitor
View new user registrations and role changes.

## Frequently Asked Questions

### What suspicious patterns does the scanner detect?
The scanner looks for:
- `eval(` - Dynamic code execution
- `base64_decode(` - Base64 decoding
- `shell_exec(` - System command execution
- `system(` - System command execution
- `passthru(` - Unix command execution
- And more...

### Will I be notified about every plugin activation?
Yes, if email alerts are enabled in the settings.

### Can I disable specific monitoring features?
Yes, all monitoring features can be toggled in the Settings page.

## Support

For support, please visit the GitHub repository or contact the developer.

## License

GPL v2 or later
