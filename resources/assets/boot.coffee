###
Webpack has issues generating css source maps with scss files that are in the
same directory as entry js.  So this entry file dials out to modules in sub
directories to work around this.
###

# Load styles that aren't referenced within JS
require 'start/app.styl'

# Async request app.js so that it doesn't block the DOM
require ['start/app']
