import {ref} from "vue";

const selected_ids = ref([]);

const updateSelectedId = (row_checkbox) => {
    const value = row_checkbox.value;
    const index = selected_ids.value.indexOf(value)

    if (row_checkbox.checked && index === -1) {
        selected_ids.value.push(value)
    } else if (index !== -1) {
        selected_ids.value.splice(index, 1);
    }
}

const handleTableCheckboxClick = (event) => {
    const target = event.target;
    const checked = target.checked;

    target.closest('table')
        .querySelectorAll('tbody tr input')
        .forEach(input => {
            input.checked = checked
            updateSelectedId(input)
        })
}

const handleRowCheckboxClick = (event) => {
    const target = event.target;

    updateSelectedId(target);

    const all_row_checkbox = target.closest('table')
        .querySelectorAll('tbody tr input[type="checkbox"]');

    const checked_rows_checkbox = [...all_row_checkbox]
        .filter(row_checkbox => row_checkbox.checked);

    target.closest('table')
        .querySelector('thead th input')
        .checked = all_row_checkbox.length === checked_rows_checkbox.length
}

const handleRowClick = (row_id, route) => {
    location.href = route.replace('__ROW_ID__', row_id)
}

const resetCheckbox = (table_id) => {
    const table = document.getElementById(table_id);
    table.querySelector('thead th input').checked = false

    const all_row_checkbox = table.querySelectorAll("tbody tr input[type='checkbox']");
    [...all_row_checkbox]
        .forEach((row_checkbox) => {
            if (row_checkbox.checked) {
                row_checkbox.checked = false
            }
        });
    selected_ids.value = []
}

export {handleRowClick, handleRowCheckboxClick,  handleTableCheckboxClick, resetCheckbox, selected_ids}
