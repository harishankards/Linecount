function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
$('input[type="text"]').focus(function() {
$(this).addClass("focus");
});
$('input[type="text"]').blur(function() {
$(this).removeClass("focus");
$(this).addClass("aftertext");/*Here Use "aftertext for getting black color font"*/
});
$('input[type="password"]').focus(function() {
$(this).addClass("focus");
});
$('input[type="password"]').blur(function() {
$(this).removeClass("focus");
$(this).addClass("aftertext");/*Here Use "aftertext for getting black color font"*/
});
$('textarea').focus(function() {
$(this).addClass("focus");
});
$('textarea').blur(function() {
$(this).removeClass("focus");
$(this).addClass("aftertext");/*Here Use "aftertext for getting black color font"*/
});
$('select').focus(function() {
$(this).addClass("focus");
});
$('select').blur(function() {
$(this).removeClass("focus");
$(this).addClass("aftertext");/*Here Use "aftertext for getting black color font"*/
});
$('checkbox').focus(function() {
$(this).addClass("focus");
});
$('checkbox').blur(function() {
$(this).removeClass("focus");
$(this).addClass("aftertext");/*Here Use "aftertext for getting black color font"*/
});