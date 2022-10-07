
timer = setInterval(countDown, 1000);
function countDown() {
    let now = new Date().getTime();
    let expectedTime = new Date('Oct 10 2022 23:59:59');
    let cd = new Date(expectedTime - now);
    if (cd <= 0) {
        clearInterval(timer);
        $.ajax({
            url: 'server/unlink.php',
            type: 'POST',
            success: (res) => {
                location.href = 'https://bivr.io';
                console.log('Files deleted');
            },
            error: (e) => console.log(e)
        });
    }
    let days = Math.floor((cd / (1000 * 60 * 60 * 24)));
    let hours = Math.floor((cd % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((cd % (1000 * 60 * 60)) / (1000 * 60))
    let seconds = Math.floor((cd % (1000 * 60)) / 1000)

    $('#day').html(zeroPad(days));
    $('#hrs').html(zeroPad(hours));
    $('#min').html(zeroPad(minutes));
    $('#sec').html(zeroPad(seconds));
}

function zeroPad(str) {
    let timeString = String(str);
    while (timeString.length < 2) {
        timeString = `0${timeString}`;
    }
    return timeString
}