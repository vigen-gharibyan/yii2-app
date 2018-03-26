$('#my a').click(function (e) {
	e.preventDefault();
	$(this).tab('show');
});

$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});

tinymce.init({
    selector: "textarea.editor",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "print preview media | insertfile undo redo | forecolor backcolor emoticons | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ],
	height: 400,
//	menubar: false,
//	toolbar_items_size: 'small',
});
