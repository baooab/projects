;(function () {
	"use strict"

	let c = console;
	let d = document;
	let w = window;

	w.c = c;
	w.d = d;

	c.l = function (info) {
		c.log(info);
	};

	d.w = function (info) {
		d.write(info);
	};

}())