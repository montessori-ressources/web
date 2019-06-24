"use strict";

String.prototype.replaceAll = function(search, replacement) {
  var target = this;
  return target.split(search).join(replacement);
};

class CardUploader {


/*
  handleChangeOneFiles(input) {
    input.addEventListener('change', this.handleChangeOne);
  }
  
  handleChangeOne(e) {
    e.preventDefault()
    console('handle change one')
    //    var tgt = e.target || window.event.srcElement,               
    //    updateImageDisplay(tgt.files, i)
  }
*/

  /**
   * @param {*} uploadForm Require a form to load the input file 
   */
  constructor(uploadCardElm) {
    // TODO Test if the uploadFormElm is a form

    this.cardsDOM = uploadCardElm.querySelector('.cards')

    if(this.cardsDOM != null) {
      
      this.cards = new Array()

      // Drag and Drop Zone
      //this.area = this.createDropArea()
      //uploadCardElm.insertBefore(this.area,uploadCardElm.firstChild);

      // Add event on all input file
      const inputFiles = uploadCardElm.querySelectorAll('input[type="file"]')
      inputFiles.forEach(handleDrop)

      // Add the add card button
      this.cardsDOM.after(this.addCardButton())

      this.initCards()
    }
  }

  initCards() {

    // Add preview image for each existing card
    const existingCards = document.querySelectorAll('.classified-card')
    for(var i=0; i<existingCards.length; i++) {
      const previewImg = document.createElement('img')
      previewImg.setAttribute('id', 'image-'+ i)
      previewImg.className = "preview"
      existingCards[i].querySelector('.preview-box').append(previewImg)

      // add an empty card in the array
      const card = new Card(i)
      this.cards.push(card)
    }
  }

  addCardButton() {
    const btnAddCard = document.createElement('button')
    btnAddCard.setAttribute('id', 'btn-add-card')
    btnAddCard.innerHTML = "Add a card"
    btnAddCard.addEventListener('click', addCard, false)

    const field = document.createElement('div')
    field.className = "field"
    field.append(btnAddCard)                                       

    return field
  }
  
  addCard(){ 
    const id = this.cards.length
    console.log('cards length:' + id)
    const card = new Card(id)
    this.cardsDOM.append(this.addCardDOM(card))
    this.cards.push(card)
  }

  addCard(_label, _description, _image){
    const id = this.cards.length
    const card = new Card(id)
    card.label = _label
    card.description = _description
    card.image = _image
    this.cardsDOM.appendChild(this.addCardDOM(card))
    this.cards.push(card)
  }

  /**
   * Create the drop area element (input file and label)
   */
  createDropArea() {

    /** Begin Bulma file upload */
    const bulmaFile = `
      <label class="file-label">
        <input id="massiveUpload" class="file-input" type="file" name="resume" multiple />
        <span class="file-cta">
          <span class="file-icon">
            <i class="fas fa-upload"></i>
          </span>
          <span class="file-label">
            Add images
          </span>
        </span>
      </label>`
    /** End Bulma file upload */

    // field block
    const fDropArea = document.createElement('div')
    fDropArea.className = 'drag-zone'

    ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      fDropArea.addEventListener(eventName, preventDefaults, false)   
    })
    
    // Highlight drop area when item is dragged over it
    ;['dragenter', 'dragover'].forEach(eventName => {
      fDropArea.addEventListener(eventName, highlight, false)
    })
    
    ;['dragleave', 'drop'].forEach(eventName => {
      fDropArea.addEventListener(eventName, unhighlight, false)
    })
    
    fDropArea.addEventListener('drop', this.handleDragDrop, false)
    fDropArea.addEventListener('change', this.handleDrop);

    fDropArea.innerHTML = bulmaFile
    return fDropArea
  }

  handleDragDrop(e) {
    var dt = e.dataTransfer  
    theUpload(dt)
  }

  updateLabel(aLabel, id) {
    var attr = aLabel.getAttribute('for')
    if(attr !== null) {
      const numberPattern = /\d+/g;
      attr = attr.replaceAll(numberPattern,id)
      aLabel.setAttribute('for', attr)  
    }
  }

  // TODO: Create DOM structure based on the existing structure inthe page (copy, not from scratch) 
  addCardDOM(card) {

    const id = card.id

    // 1st Card (.classified-card)
    const firstCardDOM = this.cardsDOM.querySelector('.classified-card') // can be used to create structure copy
    var clonedCard = firstCardDOM.cloneNode(true)

    // set input image id (nomenclature_cards_0_image_file)
    clonedCard.querySelector('#nomenclature_cards_0_image_file').setAttribute('id','nomenclature_cards_' + id + '_image_file')

    // set preview id (image-0)
    clonedCard.querySelector('#image-0').setAttribute('id','image-' + id)

    // set input label id (nomenclature_cards_0_label)
    clonedCard.querySelector('#nomenclature_cards_0_label').setAttribute('id','nomenclature_cards_' + id + '_label')

    // set textarea description id (nomenclature_cards_0_description)
    clonedCard.querySelector('#nomenclature_cards_0_description').setAttribute('id','nomenclature_cards_' + id + '_description')

    // set textarea descriptionWithGaps id (nomenclature_cards_0_descriptionWithGaps)
    clonedCard.querySelector('#nomenclature_cards_0_descriptionWithGaps').setAttribute('id','nomenclature_cards_' + id + '_descriptionWithGaps')

    // set all the labels ids
    var labels = clonedCard.querySelectorAll('.label')
    for (var i = 0; i < labels.length; i++) {
      this.updateLabel(labels[i], id)
    }
    return clonedCard
  }

  highlight(){
    this.area.classList.add('highlight')
  }

  unhighlight() {
    this.area.classList.remove('highlight')
  }

}

class Card {
  constructor(id) {
    this.id = id
    this.label = ''
    this.description = ''
    this.descriptionWithGaps = ''
    this.image = null;
  }
}

function handleDrop(e) {
  /*
  e.preventDefault()
  var tgt = e.target || window.event.srcElement,
  files = tgt.files;                
  theUpload(tgt)
  */
  console.log('Handle error')
}


function theUpload(dataTemplate) {
  var files = dataTemplate.files
  console.log('number of files to transfer:' + files.length)
  
  for(let i=0; i<files.length; i++) {
      var tmpDT = new DataTransfer()
      tmpDT.items.add(dataTemplate.files.item(i)) // 1st file
      updateImageDisplay(tmpDT.files, i)
  }
}

function updateImageDisplay(files, imgID) {

  // FileReader support
  if (FileReader && files && files.length) {
      var fr = new FileReader();
      fr.onload = function () {
          let currImg = document.getElementById('image-'+imgID)

          if(currImg === undefined || currImg === null) {
              console.log('create a new element !!')
          } else {
              currImg.src = fr.result;
              const descItem = 'nomenclature_cards_'+imgID+'_description'
              //console.log('get description')
              getImageDetails(currImg, descItem)
              
              // Set the input file value
              let currFile = document.getElementById('nomenclature_cards_'+imgID+'_image_file')
              currFile.files = files;
          }
      }
      fr.readAsDataURL(files[0]);
  }

  // Not supported
  else {
      // fallback -- perhaps submit the input to an iframe and temporarily store
      // them on the server until the user's session ends.
      console.log('not supported')
  }
}

function getDescription(item) {
  return function() {
      
      var description = EXIF.getTag(this, 'ImageDescription');
      var allMetaDataSpan = document.getElementById(item);
      allMetaDataSpan.value = JSON.stringify(description, null, "\t")
      //allMetaDataSpan.innerHTML = JSON.stringify(description, null, "\t");
  }
}

function getImageDetails(currImg, param) {
  //var currImg = document.getElementById("image-1");
  EXIF.getData(currImg, getDescription(param));
}

// TODO Remove useless global functions !!!
document.documentElement.classList.add('html-js');

const cardUploader = new CardUploader(document.querySelector('.card-uploader'))

function highlight(e) {
  cardUploader.highlight()
}

function unhighlight(e) {
  cardUploader.unhighlight()
}

function preventDefaults (e) {
  e.preventDefault()
  e.stopPropagation()
}

function addCard(e) {
  cardUploader.addCard()
  e.preventDefault()
  e.stopPropagation()
}
/*
function handleDrop(e) {
  var dt = e.dataTransfer

  console.log('number of files to transfer:' + dt.files.length)
//  for(var i=0; i< dt.files.length;i++) {
   const i = 0;
    var tmpDT = new DataTransfer()
    tmpDT.items.add(dt.files.item(i))
    console.log('image name: ' + dt.files.item(i).name)

    //var targetFile = document.querySelector('#nomenclature_cards_0_image_file')
    //targetFile.files = tmpDT.files
    //console.log('target name' + targetFile.files[0].name)

//    this.preview(dt.files.item(i))WRONG !!!

//  }

  var files = dt.files

  // hide the text and display the loading
  handleFiles(files)
}

function handleFiles(files) {

  files = [...files]
  //files.forEach(uploadFile)
  files.forEach(previewFile)
}


function previewFile(file) {  
  console.log('preview the file !!')
  let reader = new FileReader()
  reader.readAsDataURL(file)
  reader.onloadend = function() {

    let img = null
    let label = ''
    let description = ''

    // TODO: GEt EXIF description // only when the image is loaded !!!
    //EXIF.getData(reader.result, function() {
    //    description = EXIF.getTag(this, 'ImageDescription');
    //});

    label = getLabel(file.name)
    cardUploader.addCard(label, description, reader.result)
  }
  
}

function getLabel(filename) {
  let label = filename.split('.').slice(0, -1).join('.').replaceAll('_', ' ');
  return label
}

function uploadFile(file, i) {
  var url = 'http://localhost/montessori-ressources/upload-classified-card.php'
  var xhr = new XMLHttpRequest()
  var formData = new FormData()
  xhr.open('POST', url, true)
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')

  // Update progress (can be used to show progress indicator)
  xhr.upload.addEventListener("progress", function(e) {
    updateProgress(i, (e.loaded * 100.0 / e.total) || 100)
  })

  xhr.addEventListener('readystatechange', function(e) {
    if (xhr.readyState == 4 && xhr.status == 200) {
      updateProgress(i, 100) // <- Add this
    }
    else if (xhr.readyState == 4 && xhr.status != 200) {
      // Error. Inform the user
    }
  })

  formData.append('upload_preset', 'ujpu6gyk')
  formData.append('file', file)
  xhr.send(formData)
}

function uploadFile(file) {
  var url = 'http://localhost/montessori-ressources/upload-classified-card.php'
  let formData = new FormData()

  formData.append('nomenclatureImages[]', file)

  fetch(url, {
    method: 'POST',
    body: formData
  })
  .then(() => { 
    updateProgress(i, 100) // <- Add this
    // Done. Inform the user
  })
  .catch(() => { console.log('Unable to uplad the file...') })

}
*/

/* End drag and drop image code */