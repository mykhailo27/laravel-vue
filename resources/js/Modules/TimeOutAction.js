let search_timer;

const StartSearchTimer = (searchTypingDone, data) => {
    clearTimeout(search_timer);

    search_timer = setTimeout(function () {
        searchTypingDone(data)
    }, 1000);
};

const clearSearchTimer = () => {
    clearTimeout(search_timer)
}

export {StartSearchTimer, clearSearchTimer}
