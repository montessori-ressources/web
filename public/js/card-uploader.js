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

    const field = document.createElement('div')
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
    fDropArea.className = 'field field-file drop-area'

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

  /** 
   * 
   * TODO: Create DOM structure based on the existing structure inthe page (copy, not from scratch) 
   * 
   * */
  addCardDOM(card) {

    console.log('add a card...')
    
    // try to retreive existing card (nomenclature_cards_<id>_image_file)
    this.currentCard = this.cardsDOM.querySelector('#nomenclature_cards_' + card.id + '_image_file')

    console.log('the file value: ' + currentCard.id)

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

/** TODO Remove useless global functions !!! */
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

  //var files = dt.files

  // hide the text and display the loading
  //handleFiles(files)
}

function previewFile(file) {  
  console.log('preview the file !!')
  let reader = new FileReader()
  reader.readAsDataURL(file)
  reader.onloadend = function() {

    let img = null
    let label = ''
    let description = ''

    /*
    // TODO: GEt EXIF description // only when the image is loaded !!!
    EXIF.getData(reader.result, function() {
        description = EXIF.getTag(this, 'ImageDescription');
    });
    */

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
    /* Done. Inform the user */
  })
  .catch(() => { console.log('Unable to uplad the file...') })
}

String.prototype.replaceAll = function(search, replacement) {
  var target = this;
  return target.split(search).join(replacement);
};
/* End drag and drop image code */