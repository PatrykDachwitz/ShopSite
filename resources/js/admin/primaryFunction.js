window.addEventListener('load', () => {
    const buttonToolbar = document.querySelectorAll('.btn-custom');

    const InputsFile = document.querySelectorAll('.btn-add-file');

    InputsFile.forEach( btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const randomNumber = getRandom();
            const containerName = btn.dataset.type;
            const newInput = createNewFileInput(randomNumber, containerName);
            const container = document.querySelector(`div[data-container="${containerName}"]`);

            container.append(newInput);
            document.querySelector(`a[data-value="${randomNumber}"]`).addEventListener('click', quest => {
                const delDiv = document.querySelector(`div[data-value="${randomNumber}"]`);
                console.log(delDiv);
                container.removeChild(delDiv);
            });



        });
    });

    buttonToolbar.forEach( btn => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.value;
            const actualyAvailableContent = document.querySelectorAll('.customContent.d-flex');
            const availableContent = document.querySelector('div[data-content="' + type + '"]');
            actualyAvailableContent.forEach(cnt => {
                cnt.classList.remove('d-flex');
                cnt.classList.add('d-none');
            });
            availableContent.classList.remove('d-none');
            availableContent.classList.add('d-flex');

        });
    });
});

function getRandom() {
    const random = Math.random();
    const randomString = random.toString();
    return randomString.replace("0.", "9123");
}

function createNewFileInput (id, device) {
    const mainContainer = document.createElement('div');
    mainContainer.classList.add('form-graphic__group-item', 'shadow-sm', 'p-2');
    mainContainer.dataset.value = id;
    const secondaryDiv = document.createElement('div');
    secondaryDiv.classList.add('form-graphic__group-picture-title', 'ms-3');

    const inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = `file[${device}][]`;

    secondaryDiv.append(inputFile);
    mainContainer.append(secondaryDiv);

    const lastDiv = document.createElement('div');
    lastDiv.classList.add('form-graphic__group-radio', 'me-3');

    const inputRadio = document.createElement('input');
    inputRadio.type = 'radio';
    inputRadio.classList.add('form-graphic__radio');

    const spanRadio = document.createElement('span');
    spanRadio.classList.add('fs-5', 'mx-2');
    spanRadio.innerText = 'Domyślny';

    const deleteLink = document.createElement('a');
    deleteLink.classList.add('ms-3');
    deleteLink.dataset.value = id;

    const picture = document.createElement('picture');
    const source = document.createElement('source');
    const image = document.createElement('img');

    source.type = 'image/webp';
    source.srcset = '/icon/delete.webp';
    image.src = '/icon/delete.png';
    image.width = '30';
    image.height = '30';


    picture.append(source);
    picture.append(image);
    deleteLink.append(picture);

    lastDiv.append(inputRadio);
    lastDiv.append(spanRadio);
    lastDiv.append(deleteLink);
    mainContainer.append(lastDiv);

    return mainContainer;
}