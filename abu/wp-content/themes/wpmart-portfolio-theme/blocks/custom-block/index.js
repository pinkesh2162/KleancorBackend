/**
 * Blocks => custom-block => index.js
 */

// Import necessary dependencies
const { registerBlockType } = wp.blocks;
const { RichText } = wp.editor;

// Register the custom block
registerBlockType("wpmart-portfolio/custom-block", {
  title: "WpMart Portfolio Block",
  icon: "shield", // Use Dashicons: https://developer.wordpress.org/resource/dashicons/
  category: "common",
  attributes: {
    content: {
      type: "string",
      source: "html",
      selector: "p",
    },
  },

  // Defines the edit behavior of your block
  edit: function (props) {
    const {
      attributes: { content },
      setAttributes,
      className,
    } = props;

    function onChangeContent(newContent) {
      setAttributes({ content: newContent });
    }

    return (
      <RichText
        tagName="p"
        className={className}
        onChange={onChangeContent}
        value={content}
        placeholder="Add your custom content here."
      />
    );
  },

  // Defines the saved output
  save: function (props) {
    return <RichText.Content tagName="p" value={props.attributes.content} />;
  },
});
