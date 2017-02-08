
1. Udacity Frontend Nanodegree Style Guide[1] 推荐十六进制的颜色值使用小写字母

.animal-description {
	width: 300px;
	border: 1px solid #CCC;
==>
.animal-description {
	width: 300px;
	border: 1px solid #ccc;

2. ID名和类名不建议作为元素选择器的限定符存在，把类名和选择器组合成新的类名。

.animal-favorite-item span{

==>

.animal-favorite-item-span {

3. 中文需要加些样式让文字看起来是粗体的

body { 
    font-family: DFKai-SB, Microsoft JhengHei, MingLiU, Apple LiSung 
}

[1]:http://udacity.github.io/frontend-nanodegree-styleguide/css.html