"use strict";

class CardUploader {

  /**
   * @param {*} uploadForm Require a form to load the input file 
   */
  constructor(uploadCardElm) {
    // TODO Test if the uploadFormElm is a form

    this.cardsDOM = uploadCardElm.querySelector('.cards')

    if(this.cardsDOM != null) {
      
      this.cards = new Array()

      // A Card (.classified-card)
      //this.aCardDOM = this.cardsDOM.querySelector('.classified-card') // can be used to create structure copy

      // Drag and Drop Zone
      this.area = this.createDropArea()

      uploadCardElm.insertBefore(this.area,uploadCardElm.firstChild);

      // Add the add card button
      //append(this.addCardButton())

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
    }
  }
/*
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
*/
  /*
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
*/

  /**
   * Create the drop area element (input file and label)
   */
  createDropArea() {

    /** Begin Bulma file upload */
    const bulmaFile = `
      <label class="file-label">
        <input id="massiveUpload" class="file-input" type="file" name="resume">
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

    fDropArea.innerHTML = bulmaFile
    return fDropArea
  }

  handleDragDrop(e) {
    var dt = e.dataTransfer  
    theUpload(dt)
  }

  /*

   // TODO: Create DOM structure based on the existing structure inthe page (copy, not from scratch) 
  addCardDOM(card) {

    console.log('add a card...'+card.id)
    
    // try to retreive existing card (nomenclature_cards_<id>_image_file)
    this.currentCard = this.cardsDOM.querySelector('#nomenclature_cards_' + card.id + '_image_file')
    if(this.currentCard === undefined) {
      console.log('Create a new block')
      
    } else {
      console.log('Update the existing block' + this.currentCard.id)

    }
  }

  updateExistingCardDOM(card) {
    console.log('udate existing card')
  }

  addNewCardDOM(card) {
    // meta data block 
    const cols1= document.createElement('div')
    cols1.className = 'columns'

    // the preview image
    const col11 = document.createElement('div')
    col11.className = 'column is-one-quarter'

    cols1.append(col11)

    const preview = this.createPreviewImage(card.id, card.image)
    col11.append(preview)

    const col12 = document.createElement('div')
    col12.className = 'column'
    col12.append(this.createField('label-'+card.id, 'Label', 'nomenclature[cards][' + card.id + '][label]', 'input', card.label))

    // label + description + descripion with gaps
    const cols2 = document.createElement('div')
    cols2.className = 'columns'

    const col21 = document.createElement('div')
    col21.className = 'column'

    col21.append(this.createField('description-'+card.id, 'Description', 'nomenclature[cards][' + card.id + '][description]', 'textarea', card.description))
    
    const col22 = document.createElement('div')
    col22.className = 'column'
    col22.append(this.createField('descriptionWithGaps-'+card.id, 'Description with Gaps', 'nomenclature[cards][' + card.id + '][descriptionWithGaps]', 'textarea', card.description))

    cols2.append(col21)
    cols2.append(col22)

    col12.append(cols2)
    cols1.append(col12)

    const legend = document.createElement('legend')
    legend.innerHTML = 'Card ' + card.id

    const fieldset = document.createElement('fieldset')
    fieldset.className = 'classified-card'

    fieldset.append(legend)
    fieldset.append(cols1) 

    return fieldset

  }

  createPreviewImage(id, image) {
    const field = this.createField(id, 'Image', 'nomenclature[cards][' + id + '][image][file]','image')
    
    const imgField = document.createElement('img')
    if(image != null && image != '' && image != undefined)
      imgField.src = image

    const container = document.createElement('div')
    container.className = 'preview'
    container.append(imgField)
    container.append(field)
    return container
  }

  createField(id, name='', fieldName='', type, value='') {

    // The label
    const label = document.createElement('label')
    label.setAttribute('for', id)
    label.innerHTML = name

    // The input
    let input = null
    switch (type) {
      case 'textarea':
        input = document.createElement('textarea')
        input.className='textarea'
        break
      case 'image':
          input = document.createElement('input')
          input.setAttribute('type', 'file')  
          break      
      default:
        input = document.createElement('input')
        input.setAttribute('type', 'text')
        input.className='input'
    }

    input.setAttribute('id', id)
    input.setAttribute('name', fieldName)
    input.value = value

    const field = document.createElement('div')
    field.className = 'field'
    field.append(label)

    const control = document.createElement('div')
    control.className = 'control'
    control.append(input)
    field.append(control)

    return field
  }
*/
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


/*
function addCard(e) {
  cardUploader.addCard()
  e.preventDefault()
  e.stopPropagation()
}

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
String.prototype.replaceAll = function(search, replacement) {
  var target = this;
  return target.split(search).join(replacement);
};

/* End drag and drop image code */