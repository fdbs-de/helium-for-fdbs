// Get all .manifest.js files in the resources\js\Pages\Apps\Pages\Sections directory and return them as an object array
const Templates = require
.context('@/Pages/Apps/Pages/Sections', true, /\.manifest\.js$/)
.keys()
.map(key => {
    return require('@/Pages/Apps/Pages/Sections/' + key.slice(2)).default
}).reduce((map, section) => {
    map[section.type] = section
    return map
}, {})



export default Templates