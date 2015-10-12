"use strict";


var moment = require('./vendor/moment-with-locales');
moment.locale('fr');


require('./momentify')(moment);


var hljs = require('highlight.js');
hljs.initHighlightingOnLoad();