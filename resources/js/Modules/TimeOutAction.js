let search_timer;

const startSearchTimer = (searchTypingDone, data) => {
    clearTimeout(search_timer);

    search_timer = setTimeout(function () {
        searchTypingDone(data)
    }, 500);
};

const clearSearchTimer = () => {
    clearTimeout(search_timer)
}

export {startSearchTimer, clearSearchTimer}
