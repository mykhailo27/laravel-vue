const filter = (data, keys, value) => {
    return data.filter(item => {
        for (const key of keys) {
            if (item[key].toLowerCase().indexOf(value.toLowerCase()) > -1)  {
                return true;
            }
        }
        return false;
    });
}

export {filter}
