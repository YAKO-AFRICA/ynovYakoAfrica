const apiClient = axios.create({
    baseURL: 'https://api.yakoafricassur.com/enov/',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    }
});

export function getPropositions() {
    return apiClient.get('getTestDsi')
    .then(response => {
        if (!response.data.error && response.data.data && !response.data.data.error) {
            return response.data.data.communeList;
        }
        return [];
    })
    .catch(error => {
        console.error('Erreur API:', error);
        return [];
    });
}


export function getDashbordData() {
    return fetch('/dashboard/data')
    .then(response => response.json())
    .then(data => {
        return data;
    })
    .catch(error => {
        console.error('Erreur API:', error);
        return null;
    });
}

export function getDdcData() {
    return fetch('/ddc/calculDataDDC')
        .then(async response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const text = await response.text();

            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Réponse non JSON:', text);
                throw e;
            }
        })
        .then(data => {
            console.log('Données DDC:', data);
            return data;
        })
        .catch(error => {
            console.error('Erreur API DDC:', error);
            return null;
        });
}


