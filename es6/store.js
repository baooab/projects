;(function () {
	"use strict"

	var store = {};

	store.set = function (key, value) {
		localStorage.setItem(key, value);
	}

	store.get = function (key) {
		return localStorage.getItem(key);
	}

	store.remove = function (key) {
		localStorage.removeItem(key);
	}

	store.clear = function () {
		localStorage.clear();
	}

	window.store = store;
}());