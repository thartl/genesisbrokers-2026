( function( wp ) {
  const { addFilter } = wp.hooks;
  const { unregisterBlockStyle, registerBlockStyle } = wp.blocks;
  const { domReady } = wp;

  /**
   * 1) Array of blocks to hide from the inserter (rather than unregister).
   *    These remain registered internally but won't be user-insertable.
   */
  // const blocksToHide = [
  //   'core/archives',
  //   'core/rss',
  //   'core/search',
  //   'core/avatar',
  //   'core/calendar',
  //   'core/comment-author-name',
  //   'core/comment-content',
  //   'core/comment-date',
  //   'core/comment-edit-link',
  //   'core/comment-reply-link',
  //   'core/comment-template',
  //   'core/comments',
  //   'core/comments-pagination',
  //   'core/comments-pagination-next',
  //   'core/comments-pagination-numbers',
  //   'core/comments-pagination-previous',
  //   'core/comments-query-loop',
  //   'core/comments-title',
  //   'core/home-link',
  //   'core/latest-comments',
  //   'core/latest-posts',
  //   'core/legacy-widget',
  //   'core/loginout',
  //   'core/navigation',
  //   'core/navigation-link',
  //   'core/navigation-submenu',
  //   'core/post-author',
  //   'core/post-author-name',
  //   'core/post-author-biography',
  //   'core/post-comments',
  //   'core/post-comments-form',
  //   'core/post-content',
  //   'core/post-date',
  //   'core/post-excerpt',
  //   'core/post-featured-image',
  //   'core/post-navigation-link',
  //   'core/post-template',
  //   'core/post-terms',
  //   'core/post-title', // we now hide it instead of unregistering
  //   'core/query',
  //   'core/query-no-results',
  //   'core/query-pagination', // we now hide it instead of unregistering
  //   'core/query-pagination-next',
  //   'core/query-pagination-numbers',
  //   'core/query-pagination-previous',
  //   'core/query-title',
  //   'core/read-more',
  //   'core/site-logo',
  //   'core/site-tagline',
  //   'core/site-title',
  //   'core/social-link',
  //   'core/social-links',
  //   'core/tag-cloud',
  //   'core/term-description',
  // ];

  /**
   * 2) Immediately register a filter to hide blocks before they're displayed in the editor.
   */
  // addFilter(
  //     'blocks.registerBlockType',
  //     'osimpw/hide-core-blocks',
  //     ( settings, blockName ) => {
  //       if ( blocksToHide.includes( blockName ) ) {
  //         return {
  //           ...settings,
  //           supports: {
  //             ...settings.supports,
  //             inserter: false,
  //           },
  //         };
  //       }
  //       return settings;
  //     }
  // );

  /**
   * 3) Use domReady JUST for block style unregistration/registration.
   *    By the time domReady fires, all blocks are registered.
   */
  domReady( () => {

    // Unregister certain block styles
    unregisterBlockStyle( 'core/button',    [ 'squared', 'fill' ] );
    unregisterBlockStyle( 'core/separator', [ 'default', 'wide', 'dots' ] );
    unregisterBlockStyle( 'core/quote',     [ 'default', 'large', 'plain' ] );

    // Register a custom style for the core/table block
    // registerBlockStyle( 'core/table', {
    //   name:  'list-info',
    //   label: 'List info',
    // } );
    // registerBlockStyle( 'core/group', {
    //   name:  'has-border',
    //   label: 'Border',
    // } );
    // registerBlockStyle( 'core/group', {
    //   name:  'content-overlap',
    //   label: 'Overlap ↓',
    // } );
    registerBlockStyle( 'core/columns', {
      name:  'mobile-reverse',
      label: 'Mobile Reverse',
    } );
    registerBlockStyle( 'core/group', {
      name:  'round-number',
      label: 'Round number',
    } );
    registerBlockStyle( 'core/group', {
      name:  'content-overlap',
      label: 'Overlap ↓',
    } );

  } );

} )( window.wp );
