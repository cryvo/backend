// File: crybot-engine/src/plugins/index.js
// Dynamic plugin loader for CryBot strategies

const fs = require('fs');
const path = require('path');

/**
 * Load all enabled strategy plugins from the plugins directory
 * and return an array of plugin modules.
 * Plugins must export: { name: string, params: object, scan: async function(candles, config) }
 */
function loadPlugins(config) {
  const pluginsDir = path.join(__dirname, 'plugins');
  const enabled    = config.strategies || [];

  const plugins = [];
  fs.readdirSync(pluginsDir).forEach(file => {
    if (file.endsWith('.js')) {
      const plugin = require(path.join(pluginsDir, file));
      if (enabled.includes(plugin.name)) {
        plugins.push(plugin);
      }
    }
  });

  return plugins;
}

module.exports = { loadPlugins };
