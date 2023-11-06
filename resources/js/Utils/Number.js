export function randomInt (min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

export function formatBytes(bytes, decimals = 2) {
    if (!+bytes) return '0 Bytes';

    const k = 1024;
    const sizes = ['byte', 'kilobyte', 'megabyte', 'gigabyte', 'terabyte', 'petabyte'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));

    // Use NumberFormat to format the number with the appropriate unit.


    const formatter = new

        Intl.NumberFormat(undefined, {
            style: 'unit',
            unit: sizes[i],
            unitDisplay: 'narrow',
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
        });

    return formatter.format(bytes / (k ** i));
}