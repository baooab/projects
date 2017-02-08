
##2.2 第二个参数

JSON.stringify还可以接受一个数组，作为第二个参数，指定转成字符串的属性。

第二个参数还可以是一个函数，用来更改JSON.stringify的默认行为。
---
var obj = {
	'prop1': 1,
	'prop2': 'value2',
	'prop3': 3,
};

function callback(key, value) {
	if (typeof value === 'number') {
		value = value * 2;
	}
	return value;
}

p(JSON.stringify(obj, callback)); // {"prop1":2,"prop2":"value2","prop3":6}
---
如果键值是数值，就将它乘以2，否则原样返回。注意：这是函数是递归处理所有的键值。

