function initPage(isForm) {
    if (isForm) {
        setSearchParams()
        maskInput()
        let firstInput = document.querySelector('form input:not([type=hidden]):not([readonly]), form select:not([readonly])')
        if (firstInput) {
            firstInput.focus()
        }
    }
    else {
        searchChange()
    }
}

function maskInput() {
    Inputmask('datetime', { inputFormat: 'mm/dd/yyyy' }).mask('input[data-type=date]')
    Inputmask('datetime', { inputFormat: 'HH:MM:ss' }).mask('input[data-type=time]')
    Inputmask('datetime', { inputFormat: 'mm/dd/yyyy HH:MM:ss' }).mask('input[data-type=datetime]')
    flatpickr('input[data-type=date]', {
        allowInput: true,
        dateFormat: 'm/d/Y'
    })
    flatpickr('input[data-type=time]', {
        allowInput: true,
        enableTime: true,
        enableSeconds: true,
        minuteIncrement: 1,
        noCalendar: true,
        time_24hr: true,
        dateFormat: 'H:i:S'
    })
    flatpickr('input[data-type=datetime]', {
        allowInput: true,
        enableTime: true,
        enableSeconds: true,
        minuteIncrement: 1,
        time_24hr: true,
        dateFormat: 'm/d/Y H:i:S'
    })
}

function unmaskInput() {
    document.querySelectorAll('input[data-type]').forEach(e => {
        e.inputmask.remove()
        e._flatpickr.destroy()
    })
}

function setSearchParams() {
    if (location.pathname.toLowerCase().endsWith('create')) {
        new URLSearchParams(location.search).forEach((value, key) => {
            let element = document.getElementById(key) || document.getElementById(key + value)
            if (element) {
                if (element.type == 'radio') {
                    element.click()
                    document.querySelectorAll(`[id^="${key}"]`).forEach(e => {
                        e.parentElement.classList.add('readonly')
                    })
                }
                else {
                    element.value = value
                    element.setAttribute('readonly', '')
                }
            }
        })
    }
}

function clearSearch() {
    document.getElementById('search_word').value = ''
    let index = location.search.indexOf('?sw=')
    if (index < 0) {
        index = location.search.indexOf('&sw=')
    }
    if (index >= 0) {
        let url = location.pathname + location.search.substr(0, index)
        location = url
    }
}

function search(e) {
    if (!e || e.keyCode == 13) {
        let searchWord = document.getElementById('search_word')
        let value = searchWord.value
        if (value) {
            let search = `sw=${value}&sc=${ document.getElementById('search_col').value}&so=${ document.getElementById('search_oper').value}`
            let query = (!location.search || location.search.substr(0, 4) == '?sw=' ? `?${search}` : `${location.search.split('&sw=')[0]}&${search}`)
            let matches = query.match(/page=\d+/)
            if (matches) {
                query = query.replace(matches[0], 'page=1')
            }
            let url = location.pathname + query
            location = url
        }
        else {
            searchWord.focus()
        }
    }
}

function searchChange() {
    let searchWord = document.getElementById('search_word')
    if (searchWord.getAttribute('data-type')) {
        unmaskInput()
        searchWord.outerHTML = searchWord.outerHTML.toString() //remove all mask/datepicker custom event listeners
        searchWord = document.getElementById('search_word')
    }
    let type = document.getElementById('search_col').selectedOptions[0].getAttribute('data-type') || 'text'
    if (type == 'date' || type == 'time' || type == 'datetime') {
        searchWord.setAttribute('type', 'text')
        searchWord.setAttribute('data-type', type)
        maskInput()
    }
    else {
        searchWord.setAttribute('type', type)
        searchWord.removeAttribute('data-type')
    }
    let searchOper = document.getElementById('search_oper')
    let disabled = (type != 'text')
    searchOper.options[0].disabled = disabled
    if (disabled && searchOper.selectedIndex == 0) {
        searchOper.selectedIndex = 1
    }
    if (document.activeElement.id == 'search_col') {
        searchWord.select()
    }
}

function deleteItem(e) {
    if (confirm('Delete this item?')) {
        e.parentNode.submit()
    }
}

function submitForm() { //fix nested form issue in some Edit View
    while (document.querySelector('form')) {
        document.querySelector('form').remove()
    }
    let div = document.querySelector('div[data-method]')
    let form = document.createElement('form')
    form.method = div.getAttribute('data-method')
    form.action = div.getAttribute('data-action')
    div.parentNode.prepend(form)
    form.append(div)
    form.submit()
}

function validateForm() {
    let password = document.querySelector('input[type=password]:not([data-match])')
    let match = document.querySelector('[data-match]')
    if (!password.value && (!match || !match.value)) { //do not change password
        return true
    }
    let passwordError = validatePassword(password.value)
    let isPasswordMatch = true
    if (match) {
        isPasswordMatch = document.getElementById(match.getAttribute('data-match')).value == match.value
    }
    if (passwordError) {
        alert(passwordError)
    }
    else if (!isPasswordMatch) {
        alert('Password do not match!')
    }
    let isFormValid = (!passwordError && isPasswordMatch)
    return isFormValid
}

function validatePassword(value) {
    let error = ''
    if (!/[a-z]/.test(value)) {
        error += 'Must include lowercase letter\n'
    }
    if (!/[A-Z]/.test(value)) {
        error += 'Must include uppercase letter\n'
    }
    if (!/[^A-Za-z0-9]/.test(value)) {
        error += 'Must include symbol\n'
    }
    if (!/[0-9]/.test(value)) {
        error += 'Must include number\n'
    }
    if (value.length < 6 || value.length > 10) {
        error += 'Must have length between 6 and 10'
    }
    if (error) {
        error = 'Password does not meet requirements:\n' + error
    }
    return error
}