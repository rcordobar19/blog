export default function readingTime (content) {
    if (!content) return '';
    const words = content.split(/\s/g).length;
    const minutes = words / 200;
    const readTime = Math.ceil(minutes);
    return readTime + ' min read';
}