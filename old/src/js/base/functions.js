let cachedLang = null;
let cachedAlerts = null;

// Language code from session (e.g., "en", "es")
export async function readLang() {
    if (cachedLang) return cachedLang;

    try {
        const response = await fetch(`${window.location.origin}/api/language`);
        cachedLang = await response.json();
        return cachedLang;
    } catch (error) {
        console.error('Error fetching language:', error);
    }
}

// Full alerts/messages JSON file
export async function readJSON() {
    if (cachedAlerts) return cachedAlerts;

    try {
        const response = await fetch(`${window.location.origin}/api/alerts`, { mode: 'cors' });
        cachedAlerts = await response.json();
        return cachedAlerts;
    } catch (error) {
        console.error('Error fetching alerts:', error);
    }
}

export async function t(key, subkey = null) {
    const [lang, alerts] = await Promise.all([readLang(), readJSON()]);

    if (subkey && alerts[key]?.[subkey]?.[lang]) {
        return alerts[key][subkey][lang];
    }

    if (alerts[key]?.[lang]) {
        return alerts[key][lang];
    }

    return key; // fallback
}

