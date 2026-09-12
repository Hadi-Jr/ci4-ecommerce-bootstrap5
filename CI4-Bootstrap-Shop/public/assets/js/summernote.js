$(document).ready(function () {
  $("#long-description").summernote({
    placeholder: "Write your product description...",
    minHeight: 200,
    theme: "bs5",
    disableResizeEditor: true,
    toolbar: [
      ["font", ["bold", "italic", "underline"]],
      ["para", ["ul", "ol"]],
    ],
  });

  $("#short-description").summernote({
    placeholder: "Write your short description...",
    minHeight: 100,
    theme: "bs5",
    disableResizeEditor: true,
    toolbar: [
      ["font", ["bold", "italic", "underline"]],
      ["para", ["ul", "ol"]],
    ],
  });

  $("#method-of-use").summernote({
    placeholder: "Write method of use...",
    minHeight: 100,
    theme: "bs5",
    disableResizeEditor: true,
    toolbar: [
      ["font", ["bold", "italic", "underline"]],
      ["para", ["ul", "ol"]],
    ],
  });

  $('.note-editable').css({
    'background-color': '#ffffff'
  });

  $('.note-placeholder').css({
    'font-size' : '14px'
  });

  $('.note-toolbar').css({
    'background-color': '#ffffff',
    'padding': '4px',
    'margin-left' : '4px'
  });

  $('.note-editor').css({
    'background-color': '#ffffff',
    'border-radius': '8px',
    'overflow': 'hidden',
    'border-color': '#dee2e6'
  });

  $('.note-btn').css({
    'font-size' : '11px',
    'color': '#495057'
  });

  $('.note-btn:hover').css({
    'background-color': '#f1f3f5'
  });

  $('.note-resizebar').css({
    'background-color': '#ffffff'
  });
});
