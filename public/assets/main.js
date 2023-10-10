(() => {
    const table = document.getElementById("table");
    const tbody = table.querySelector("tbody");

    let currRow = null;
    let dragElem = null;
    let mouseDownX = 0;
    let mouseDownY = 0;
    let mouseX = 0;
    let mouseY = 0;
    let mouseDrag = false;

    const init = () => {
        bindMouse();
    };

    const bindMouse = () => {
        document.addEventListener("mousedown", (event) => {
            if (event.button !== 0) return true;

            const target = getTargetRow(event.target);
            if (target) {
                currRow = target;
                addDraggableRow(target);
                currRow.classList.add("is-dragging");

                const coords = getMouseCoords(event);
                mouseDownX = coords.x;
                mouseDownY = coords.y;

                mouseDrag = true;
            }
        });

        document.addEventListener("mousemove", (event) => {
            if (!mouseDrag) return;

            const coords = getMouseCoords(event);
            mouseX = coords.x - mouseDownX;
            mouseY = coords.y - mouseDownY;

            moveRow(mouseX, mouseY);
        });

        document.addEventListener("mouseup", (event) => {
            if (!mouseDrag) return;

            currRow.classList.remove("is-dragging");
            table.removeChild(dragElem);

            dragElem = null;
            mouseDrag = false;
        });
    };

    let swappedElementPriority = null;
    let draggedElementPriority = null

    const setSwappedElementsPriority = (swappedPriority, draggedPriority) => {
        swappedElementPriority = swappedPriority;
        draggedElementPriority = draggedPriority
    }

    const getSwappedElementsPriority = () => {
        return [swappedElementPriority, draggedElementPriority];
    }

    const swapRow = (row, index) => {
        const currIndex = Array.from(tbody.children).indexOf(currRow);
        const row1 = currIndex > index ? currRow : row;
        const row2 = currIndex > index ? row : currRow;

        tbody.insertBefore(row1, row2);

        setSwappedElementsPriority(row1.id, row2.id);

    };
    

    const moveRow = (x, y) => {

        dragElem.style.transform = `translate3d(${x}px, ${y}px, 0)`;

        const dPos = dragElem.getBoundingClientRect();
        const currStartY = dPos.y;
        const currEndY = currStartY + dPos.height;
        const rows = getRows();

        for (let i = 0; i < rows.length; i++) {
            const rowElem = rows[i];
            const rowSize = rowElem.getBoundingClientRect();
            const rowStartY = rowSize.y;
            const rowEndY = rowStartY + rowSize.height;
            if (
                currRow !== rowElem &&
                isIntersecting(currStartY, currEndY, rowStartY, rowEndY)
            ) {
                if (Math.abs(currStartY - rowStartY) < rowSize.height / 2) {
                    swapRow(rowElem, i);
                }
            }
        }
    };


    const addDraggableRow = (target) => {
        dragElem = target.cloneNode(true);
        dragElem.classList.add("draggable-table__drag");
        dragElem.style.height = getStyle(target, "height");
        dragElem.style.background = getStyle(target, "backgroundColor");
        for (let i = 0; i < target.children.length; i++) {
            const oldTD = target.children[i];
            const newTD = dragElem.children[i];
            newTD.style.width = getStyle(oldTD, "width");
            newTD.style.height = getStyle(oldTD, "height");
            newTD.style.padding = getStyle(oldTD, "padding");
            newTD.style.margin = getStyle(oldTD, "margin");
        }
    
        table.appendChild(dragElem);
    
        const tPos = target.getBoundingClientRect();
        const dPos = dragElem.getBoundingClientRect();
        dragElem.style.bottom = `${dPos.y - tPos.y - tPos.height}px`;
        dragElem.style.left = "-1px";
    
        document.dispatchEvent(
            new MouseEvent("mousemove", {
                view: window,
                cancelable: true,
                bubbles: true,
            })
        );
    
        // Send AJAX request (update priority) on mouseup event
        dragElem.addEventListener("mouseup", () => {
            let swappedPriority = getSwappedElementsPriority()[0];
            let draggedPriority = getSwappedElementsPriority()[1];

            console.log(swappedPriority)
            console.log(draggedPriority)
        
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
        
            // Send an Ajax POST request to the Laravel route
            $.ajax({
                type: 'POST',
                url: '/update-priority',
                data: {
                    swappedPriority: swappedPriority,
                    draggedPriority: draggedPriority, 
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {                   
                    console.log(response.message);
                },
                error: function(error) {                 
                    console.error('Error:', error);
                }
            });
        });
        
    };
    

    const getRows = () => {
        return table.querySelectorAll("tbody tr");
    };

    const getTargetRow = (target) => {
        const elemName = target.tagName.toLowerCase();

        if (elemName === "tr") return target;
        if (elemName === "td") return target.closest("tr");
    };

    const getMouseCoords = (event) => {
        return {
            x: event.clientX,
            y: event.clientY,
        };
    };

    const getStyle = (target, styleName) => {
        const compStyle = getComputedStyle(target);
        const style = compStyle[styleName];

        return style ? style : null;
    };

    const isIntersecting = (min0, max0, min1, max1) => {
        return (
            Math.max(min0, max0) >= Math.min(min1, max1) &&
            Math.min(min0, max0) <= Math.max(min1, max1)
        );
    };

    init();
})();



// document.addEventListener("drop", (event) => {
//     event.preventDefault();
    
//     // Find the target row where you're dropping
//     const targetRow = getTargetRow(event.target);
    
//     // Check if the targetRow is not null and it has a unique ID
//     if (targetRow && targetRow.id) {
//         const droppedRowId = currRow.id; // Get the ID of the row being dragged
//         // Now, you have the ID of the row being dragged and the ID of the target row.
//         // You can implement your logic here to handle the drop action.
//         // For example, you can swap the data associated with these two rows.
//         // Here's a basic example of swapping IDs:
        
//         // Save the original ID of the target row
//         const originalTargetRowId = targetRow.id;
        
//         // Set the ID of the target row to the ID of the dragged row
//         targetRow.id = droppedRowId;
        
//         // Set the ID of the dragged row to the original ID of the target row
//         currRow.id = originalTargetRowId;
//     }
// });
