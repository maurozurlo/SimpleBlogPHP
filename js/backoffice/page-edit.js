


const modal = new bootstrap.Modal(document.getElementById("editElementModal"));
const elementsData = {};

// Fetch elements and populate the list
fetch("/php/cms/getElements.php")
    .then(response => response.json())
    .then(elements => {
        const elementsContainer = document.getElementById("elements");
        elements.forEach(element => {
            elementsData[element.id] = element;
            const elementDiv = document.createElement("div");
            elementDiv.classList.add("draggable-element");
            elementDiv.setAttribute("data-element-id", element.id);
            elementDiv.textContent = element.name;
            elementsContainer.appendChild(elementDiv);
        });

        initDraggableElements();

        // Fetch page elements
        fetch("/php/cms/getPage.php?pageId=1")
            .then(response => response.json())
            .then(elements => {
                elements.forEach(element => {
                    const newElement = createElement(element.id, element);
                    builder.appendChild(newElement);
                });
            });
    });





function initDraggableElements() {
    document.querySelectorAll(".draggable-element").forEach(el => {
        el.draggable = true;
        el.addEventListener("dragstart", (event) => {
            event.dataTransfer.setData("elementId", event.target.getAttribute("data-element-id"));
        });
    });
}

const builder = document.getElementById("builder");
builder.addEventListener("dragover", (event) => {
    event.preventDefault();
});

builder.addEventListener("drop", (event) => {
    event.preventDefault();
    const elementId = event.dataTransfer.getData("elementId");
    const newElement = createElement(elementId);
    builder.appendChild(newElement);
});

function createElement(elementId, data) {
    const builderElementId = data?.pageElementId ?? Date.now();
    const elementDef = elementsData[elementId];
    const variables = elementDef?.variables || {};
    const variableData = JSON.stringify(variables);

    const newElement = document.createElement("div");
    newElement.classList.add("border", "p-2", "placed-element", "relative", "d-flex", "justify-content-between", "mb-1", "align-items-center");
    newElement.dataset.id = builderElementId;
    newElement.dataset.variables = data && data.variables ? createVariableData(variables, data?.variables) : variableData;
    newElement.setAttribute("data-element-id", elementId);
    newElement.textContent = elementDef?.description || elementDef.name;
    newElement.addEventListener("click", openEditModal);

    // Create Delete Button
    const deleteButton = document.createElement("button");
    deleteButton.innerHTML = `<span aria-hidden="true">&times;</span>`;
    deleteButton.classList.add("btn", "btn-danger");
    deleteButton.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevent triggering the edit modal
        newElement.remove(); // Remove element from DOM
    });

    // Append delete button to element
    newElement.appendChild(deleteButton);

    return newElement;
}

function createVariableData(elementDefVariables, variableData) {
    return JSON.stringify(Object.entries(variableData).reduce((prev, [key, value]) => {
        return {
            ...prev,
            [key]: {
                ...elementDefVariables[key],
                value
            }
        }
    }, {}))
}

function openEditModal(event) {
    const element = event.target;
    const elementId = element.dataset.id;
    const variables = JSON.parse(element.dataset.variables || "{ }");

    document.getElementById("elementId").value = elementId;
    document.getElementById("elementDefinitionId").value = element.getAttribute("data-element-id");

    const elementFields = document.getElementById("elementFields");
    elementFields.innerHTML = "";

    for (const key in variables) {
        let fieldDiv = document.createElement("div");
        fieldDiv.classList.add("mb-3");

        const label = document.createElement("label");
        label.classList.add("form-label");
        label.textContent = key;

        const input = document.createElement("input");
        input.type = "text"; // TODO need to support several types based on variable type
        input.classList.add("form-control");
        input.name = key;
        input.placeholder = variables[key]?.default || "";
        input.value = variables[key]?.value ?? ""

        fieldDiv.appendChild(label);
        fieldDiv.appendChild(input);
        elementFields.appendChild(fieldDiv);
    }

    modal.show();
}

document.getElementById("saveElementChanges").addEventListener("click", function () {
    const elementId = document.getElementById("elementId").value;
    const elementDefId = document.getElementById("elementDefinitionId").value
    const elementDef = elementsData[Number(elementDefId)];
    const updatedVariables = {};

    document.querySelectorAll("#elementFields input").forEach(input => {
        updatedVariables[input.name] = input.value;
    });

    const element = document.querySelector(`[data-id='${elementId}']`);
    element.dataset.variables = createVariableData(elementDef.variables, updatedVariables)

    modal.hide();
});

document.getElementById("savePage").addEventListener("click", function () {
    const pageData = [];
    document.querySelectorAll("#builder .placed-element").forEach((el, i) => {
        pageData.push({
            id: el.getAttribute("data-element-id"),
            variables: Object.entries(JSON.parse(el.dataset.variables)).reduce((prev, [key, value]) => {
                return {
                    ...prev,
                    [key]: value.value || ""
                }
            }, {}),
            order: i
        });
    });

    fetch("/php/cms/savePage.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ page: 1, elements: pageData })
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        });
});

