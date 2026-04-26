let submitBtn = document.getElementById('submit_btn');
let bookForm = document.getElementById('book_form');
let errorSummaryTop = document.getElementById('error_summary_top');

let titleInput = document.getElementById('title');
let authorInput = document.getElementById('author');
let publisherIdInput = document.getElementById('publisher_id');
let yearInput = document.getElementById('year');
let isbnInput = document.getElementById('isbn'); 
let descriptionInput = document.getElementById('description'); 

let titleError = document.getElementById('title_error');
let authorInputError = document.getElementById('author_error');
let publisherIdError = document.getElementById('publisher_id_error');
let yearError = document.getElementById('year_error');
let isbnError = document.getElementById('isbn_error');
let descriptionError = document.getElementById('description_error');

let errors = {};

submitBtn.addEventListener('click', onSubmitForm);

function addError(fieldName, message) {
    errors[fieldName] = message;
}

function showErrorSummaryTop() {
    const messages = Object.values(errors);
    if (messages.length === 0) {
        errorSummaryTop.style.display = 'none';
        errorSummaryTop.innerHTML = '';
        return;
    }
    errorSummaryTop.innerHTML =
        '<strong>Please fix the following:</strong><ul>' +
        messages
            .map(function (m) {
                return '<li>' + m + '</li>';
            })
            .join('') +
        '</ul>';
    errorSummaryTop.style.display = 'block';
}

function showFieldErrors() {
    titleError.innerHTML = errors.title || '';
    authorInputError.innerHTML = errors.author || '';
    publisherIdError.innerHTML = errors.publisher_id || '';
    yearError.innerHTML = errors.year || '';
    isbnError.innerHTML = errors.isbn || '';
    descriptionError.innerHTML = errors.description || '';
}

function isRequired(value) {
    return String(value).trim() !== '';
}

function isMinLength(value, min) {
    return String(value).trim().length >= min;
}

function isMaxLength(value, max) {
    return String(value).trim().length <= max;
}

function onSubmitForm(evt) {
  evt.preventDefault();

  errors = {};

  let titleMin = titleInput.dataset.minlength || 3;
  let titleMax = titleInput.dataset.maxlength || 255;
  let yearMinMax = 4;
  let isbnMinMax = 14;

  //Title
  if(!isRequired(titleInput.value)) {
    addError('title', 'Title is required!');
  } else if(!isMinLength(titleInput.value, titleMin)) {
    addError('title', 'Title must be at least ' + titleMin + ' characters long.');
  } else if(!isMaxLength(titleInput.value, titleMax)) {
    addError('title', 'Title must be at most ' + titleMax + ' characters long.');
  }

  //Author
  if(!isRequired(authorInput.value)) {
    addError('author', 'Author is required!');
  }

  //publisher
  if(!isRequired(publisherIdInput.value)) {
    addError('publisher_id', 'Publisher is required!');
  }

  //year
  if(!isRequired(yearInput.value)) {
    addError('year', 'Year is required!');
  } else if(!isMinLength(yearInput.value, yearMinMax)) {
    addError('year', `Year must be at least ${yearMinMax} characters long.`);
  } else if(!isMaxLength(yearInput.value, yearMinMax)) {
    addError('year', `Year must be at most ${yearMinMax} characters long.`);
  }

  //ISBN
  if(!isRequired(isbnInput.value)) {
    addError('isbn', 'ISBN is required!');
  } else if(!isMinLength(isbnInput.value, isbnMinMax)) {
    addError('isbn', `ISBN must be at least ${isbnMinMax} characters long.`);
  } else if(!isMaxLength(yearInput.value, isbnMinMax)) {
    addError('isbn', `ISBN must be at most ${isbnMinMax} characters long.`);
  }

//Description
  if(!isRequired(descriptionInput.value)) {
    addError('description', 'Description is required!');
  }

  showFieldErrors();
  showErrorSummaryTop();

  if (Object.keys(errors).length === 0) {
    bookForm.submit();
    // alert('Form data valid.')
  }
  
}