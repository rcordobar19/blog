import excerpt from './Excerpt';
import readingTime from './ReadingTimeFilter';

export default {
    install(Vue) {
        Vue.filter('excerpt', excerpt);
        Vue.filter('readingTime', readingTime);
    }
}