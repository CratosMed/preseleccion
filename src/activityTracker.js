import axios from 'axios';

let lastActivityTime = Date.now();

const updateActivityTime = () => {
    lastActivityTime = Date.now();
    sendActivityToServer();
};

const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
};

const sendActivityToServer = () => {
    const token = localStorage.getItem('token');
    if (token) {
        const localDate = new Date(lastActivityTime);
        const formattedDate = formatDate(localDate);

        console.log("Sending data:", {
            token: token,
            lastActivityTime: formattedDate
        });

        axios.post('http://localhost/preseleccion/sistemaapi/apirest/updateActivity.php', {
            token: token,
            lastActivityTime: formattedDate
        }, {
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            console.log("Server response:", response.data);
        }).catch(error => {
            console.error("Error al enviar la actividad del usuario:", error);
        });
    }
};

['click', 'mousemove', 'keydown'].forEach(event => {
    window.addEventListener(event, updateActivityTime);
});

setInterval(() => {
    const currentTime = Date.now();
    const fiveMinutes = 5 * 60 * 1000;
    if (currentTime - lastActivityTime > fiveMinutes) {
        localStorage.removeItem('token');
        window.location.href = '/';
    }
}, 1000);

export default updateActivityTime;
