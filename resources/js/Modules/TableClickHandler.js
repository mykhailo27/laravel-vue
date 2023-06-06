import {ref} from "vue";

const selected_id = ref([]);

const updateSelectedId = (row_checkbox) => {
    const value = row_checkbox.value;
    const index = selected_id.value.indexOf(value)

    if (row_checkbox.checked && index === -1) {
        selected_id.value.push(value)
    } else if (index !== -1) {
        selected_id.value.splice(index, 1);
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

export {handleRowClick, handleRowCheckboxClick,  handleTableCheckboxClick}
