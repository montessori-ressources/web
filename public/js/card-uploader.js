"use strict";

class CardUploader {

  /**
   * @param {*} uploadForm Require a form to load the input file 
   */
  constructor(uploadCardElm) {
    // TODO Test if the uploadFormElm is a form

    this.cardsDOM = uploadCardElm.querySelector('.cards')

    if(this.cardsDOM != null) { // if no card, don't display anything
      
      this.cards = new Array()

      // A Card (.classified-card)
      this.aCardDOM = this.cardsDOM.querySelector('.classified-card')

      //this.cardsDOM.innerHTML = "";

      // Drag and Drop Zone
      //this.area = this.createDropArea()

      //uploadCardElm.insertBefore(this.area,uploadCardElm.firstChild);

      // Add the add card button
      this.cardsDOM.append(this.addCardButton())
    }
  }

  /*initCards() {
    for(var i=0; i<this.cards.length; i++) {
      this.cardsDOM.append(this.addCardDOM(this.cards[i]))
    }
  }*/

  addCardButton() {
    const btnAddCard = document.createElement('button')
    btnAddCard.setAttribute('id', 'btn-add-card')
    btnAddCard.innerHTML = "Add a card"
    btnAddCard.addEventListener('click', addCard, false)

    const field = document.createElement('field')
    field.className = "field"
    field.append(btnAddCard)

    return field
  }

  addCard(){
    const card = new Card(this.cards.length)
    this.cards.push(card)
    this.cardsDOM.append(this.addCardDOM(card))
  }

  addCard(_label, _description, _image){
    const card = new Card(this.cards.length)
    card.label = _label
    card.description = _description
    card.image = _image
    this.cards.push(card)
    this.cardsDOM.appendChild(this.addCardDOM(card))
  }

  /**
   * Create the drop area element (input file and label)
   */
  createDropArea() {

    // set the label
    const lblDropArea = document.createElement('label')
    lblDropArea.setAttribute('for', 'classified-card-1-image')
    lblDropArea.className = 'label-image'
    lblDropArea.innerHTML = "Drag n' drop your image here...";

    // set the input file
    const iDropArea = document.createElement('input')
    iDropArea.setAttribute('id', 'classified-card-1-image')
    iDropArea.setAttribute('type', 'file')
    iDropArea.setAttribute('name', 'classified-card-images[]')
    iDropArea.className = 'input-file'

    // field block
    const fDropArea = document.createElement('div')
    fDropArea.className = 'field field-file'

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
    
    fDropArea.addEventListener('drop', handleDrop, false)
    

    fDropArea.append(lblDropArea, iDropArea)

    return fDropArea
  }

  addCardDOM(card) {

    // nomenclature[cards][0][image][file]
    // nomenclature[cards][0][label]
    // nomenclature[cards][0][description]
    // nomenclature[cards][0][descriptionWithGaps]

    // nomenclature[cards][1][image][file]
    // nomenclature[cards][1][label]
    // nomenclature[cards][1][description]
    // nomenclature[cards][1][descriptionWithGaps]
   
    //console.log('add Card !' + this.aCardDOM)

    var copy = this.aCardDOM.cloneNode(true)
    /*
    const nb = this.cards.length+1
    copy = copy.replaceAll('nomenclature[cards][0][image][file]','nomenclature[cards][' + nb + '][image][file]')
    copy = copy.replaceAll('nomenclature[cards][0][label]','nomenclature[cards][' + nb + '][label]')
    copy = copy.replaceAll('nomenclature[cards][0][description]','nomenclature[cards][' + nb + '][description]')
    copy = copy.replaceAll('nomenclature[cards][0][descriptionWithGaps]','nomenclature[cards][' + nb + '][descriptionWithGaps]')
    */

    return copy
/*    
    const metaData = document.createElement('div')
    metaData.className = 'meta-data'
    metaData.append(this.createField('label-'+card.id, 'Label', 'input', card.label))
    metaData.append(this.createField('description-'+card.id, 'Description', 'textarea', card.description))

    const preview = this.createPreviewImage(card.image)

    const legend = document.createElement('legend')
    legend.innerHTML = 'Card ' + card.id

    const fieldset = document.createElement('fieldset')
    fieldset.className = 'classified-card'

    fieldset.append(legend)
    fieldset.append(preview)
    fieldset.append(metaData) 

    return fieldset
*/    
  }

  createPreviewImage(image) {
    const img = document.createElement('img')
    if(image != null && image != '' && image != undefined)
      img.src = image

    const container = document.createElement('div')
    container.className = 'preview'
    container.append(img)
    return container
  }

  createField(id, name='', type, value='') {

    // The label
    const label = document.createElement('label')
    label.setAttribute('for', id)
    label.innerHTML = name

    // The input
    let input = null
    switch (type) {
      case 'textarea':
        input = document.createElement('textarea')
        break
      default:
        input = document.createElement('input')
        input.setAttribute('type', 'text')
    }

    input.setAttribute('id', id)
    input.setAttribute('name', id)
    input.value = value

    const field = document.createElement('div')
    field.className = 'field'
    field.append(label)
    field.append(input)

    return field
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
    this.id = id+1
    this.label = ''
    this.description = ''
    this.descriptionWithGaps = ''
    this.image = null;
  }

}

document.documentElement.classList.add('html-js');

const cardUploader = new CardUploader(document.querySelector('.card-uploader'))

function highlight(e) {
  cardUploader.highlight()
}

function unhighlight(e) {
  cardUploader.unhighlight()
}

function addCard(e) {
  cardUploader.addCard()
  e.preventDefault()
  e.stopPropagation()
}

function preventDefaults (e) {
  e.preventDefault()
  e.stopPropagation()
}

function handleDrop(e) {
  var dt = e.dataTransfer
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
  let reader = new FileReader()
  reader.readAsDataURL(file)
  reader.onloadend = function() {

    let img = null
    let label = ''
    let description = ''

    // TODO: GEt EXIF description // only when the image is loaded !!!
    EXIF.getData(reader.result, function() {
        description = EXIF.getTag(this, 'ImageDescription');
    });

    label = file.name.split('.').slice(0, -1).join('.');
    cardUploader.addCard(label, description, reader.result)
  }
  
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
    /* Done. Inform the user */
  })
  .catch(() => { console.log('Unable to uplad the file...') })
}

String.prototype.replaceAll = function(search, replacement) {
  var target = this;
  return target.split(search).join(replacement);
};
/* End drag and drop image code */