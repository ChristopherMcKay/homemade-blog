// get the P, B and I buttons and make them all listen for the same function
const pBtn = document.getElementById('p');
pBtn.addEventListener('click', formatText);

const bBtn = document.getElementById('strong');
bBtn.addEventListener('click', formatText);

const iBtn = document.getElementById('em');
iBtn.addEventListener('click', formatText);

// get the main blog entry box (the textarea)
const blogEntry = document.getElementById('blogEntry');

// get the preview div
const previewDiv = document.getElementById('preview-div');

// get the Preview button
const previewBtn = document.getElementById('preview');
previewBtn.addEventListener('click', togglePreview);

// get the fonts menu
const fontsMenu = document.getElementById('fonts-menu');
fontsMenu.addEventListener('change', setFont);

// get the heading menu
const hMenu = document.getElementById('h-menu');
hMenu.addEventListener('change', setHeading);

// link box and link button
const linkBox = document.getElementById('link-box');
const linkBtn = document.getElementById('link-btn');
linkBtn.addEventListener('click', setHyperlink);

// function formatText() runs when a Text Format button is clicked: P, B or I
function formatText() {
    
    // 1.) get the ID of the clicked button
    let tagName = event.target.id;
    
    // 2.) get ALL the text from the main blog entry box
    let allText = blogEntry.value;
    
    // 3.) get the selected text from the main blog entry box
    let selectedText = window.getSelection();
    
    // 4.) surround the selected text w the appropriate tag
    let formattedText = `<${tagName}>${selectedText}</${tagName}>`;
    
    // 5.) string replace: newly formatted text replaces selection
    allText = allText.replace(selectedText, formattedText);
    
    // 6.) re-publish the blog text to refresh the main blog entry box
    blogEntry.value = allText;
    
} // end function formatText()

function togglePreview() {
    
    // change the button text from Preview to Edit and vice-versa
    if(event.target.innerHTML == "Preview") {
       event.target.innerHTML = "Edit";
       previewDiv.style.display = "block"; // hide the preview div
       blogEntry.style.display = "none";
       // copy text from blogEntry textarea to preview div for rendering
       let allText = blogEntry.value;
       previewDiv.innerHTML = allText;
    } else {
       event.target.innerHTML = "Preview";
       blogEntry.style.display = "block";
       previewDiv.style.display = "none"; // hide the preview div
    }
        
} // end function togglePreview()

function setFont() {
    
    // 1.) get ALL the blog text
    let allText = blogEntry.value;
    // 2.) get the selected text
    let selectedText = window.getSelection();
    // 3.) get the font chosen in the fonts menu
    let font = fontsMenu.value;
    // 4.) wrap selected text in span tag w font
    let formattedText = `<span style="font-family:${font}">${selectedText}</span>`;
    // 5.) do a string replace: formatted text for selected text
    allText = allText.replace(selectedText, formattedText);
    // 6.) re-output all text
    blogEntry.value = allText;
    
} // end function setFont()

// func to run on click of img in blog CMS
function setHeading() {
    
    // 1.) get ALL the blog text
    let allText = blogEntry.value;
    // 2.) get the selected text
    let selectedText = window.getSelection();
    // 3.) get the font chosen in the fonts menu
    let h = hMenu.value;
    // 4.) wrap selected text in h tag
    let formattedText = `<${h}>${selectedText}</${h}>`;
    // 5.) do a string replace: formatted text for selected text
    allText = allText.replace(selectedText, formattedText);
    // 6.) re-output all text
    blogEntry.value = allText;
    
} // end function setFont()

// deploy the clicked image into the blog entry text
function deployImage() {
  
  // just the fileName, without the full path
  let fileName = event.target.src.split('/').pop()
  
  // current cursor position (string index) in the blog entry box
  let x = blogEntry.selectionStart;
    
  let flt = 'none'
  let w = event.target.width
  alert(w)
  // if pic is less than 70% width of blog text, float it left
  if(w < 500) {
      flt = 'left'
  }
  
  let fig = `<figure style="margin:0 1rem 0 0; float:${flt}"><img src="${event.target.src}" alt="${fileName}" style="max-width:100%;"><figcaption>${event.target.title}</figcaption></figure>`
  
  // insert the image HTML tag in the X spot
  blogEntry.value = blogEntry.value.slice(0, x) + fig + blogEntry.value.slice(x)
  
}

function setHyperlink() {

    // 1.) get ALL the blog text
    let allText = blogEntry.value;
    // 2.) get the text from the link box
    let url = linkBox.value;
    // 3.) get the selection
    let selectedText = window.getSelection();
    // 4.) wrap the selection in a link tag, w href = link box text
    let formattedText = `<a href="${url}" target="_blank">${selectedText}</a>`;
    // 5.) do a string replace: formatted text for selected text
    allText = allText.replace(selectedText, formattedText);
    // 6.) re-output all text
    blogEntry.value = allText;

} // setHyperlink()




