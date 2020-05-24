# Seeds Media

Provide needed media types and enhance out of the box media experience.

- Create all needed media types (Local Video, Remote Video, Image, File, Audio)
- Allow user to select image styles for embded media inside CKeditor **(Legacy, will be removed in Drupal 9)**
- Prevent users from changing media which are set as default, with a custom permissions to block/allow editing for those entities.
- Provides a way to edit media within the media library widget. (Depends on [this ](https://www.drupal.org/files/issues/2019-10-18/2985168-21.patch) patch).
- Show warning message on edit media form if the media is used in another entity.
- Create Social media menu.


## Show warning message when editing media

From the toolbar, go to Configuration > Content Authoring > Seeds Media and check the box "Check Media Usability".

The warning should show if the media is being used elsewhere.


## Default Media

Go to any media entity, there should be a checkbox "Default Media", check it to set the entity as a default media.
