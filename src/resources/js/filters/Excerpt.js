export default function excerpt (content, words) {
    if (!content) return '';

    content = content.substring(0, words) + '...';
    content = content.replace(/<br>/gi, "\n");
    content = content.replace(/<p.*>/gi, "\n");
    content = content.replace(/<(?:.|\s)*?>/g, "");

    return content;
}