[title]: # ITIMPFY Location Description Shortcode Plugin

## Objective
Simplify the management and generation of adding/removing/updating Mapify kiosk locations.
Previously, HTML was added in the post description in the rich text editors. This led to several issues:
- Code being 'minified' when saved
- Code sometimes breaking when saved
- Updates to the rich text having unexpected effects on the layout, such as tables
- Diminished readability

## Code Changes
No code changes are required. Simply install the plugin
- .zip upload from the GUI
- in the plugins folder via SFTP

## Shortcode Examples & Explanation

### itimpfy_location_main

#### Purpose
Generates HTML for main description (topmost text-input on map-locations post editor)

#### Shortcode Parameters
- `name` - Name of location
- `address` - Address of location, all one line, comma separated
- `cash` - Doesn't expect any specific values. For ex: `cash="true"` does the same as `cash="foo"`
- `check` - Doesn't expect any specific values. For ex: `check="true"` does the same as `check="foo"`
- `hours` - Accepts hours (renders whatever format is input) separated by semicolons. A new line is made for each hours group between semicolons

#### Shortcode Example
`[itimpfy_location_main name="New Location" address="123 Main St." cash="true" check="true" hours="Mon - Fri: 5am-4pm; Sat & Sun: Closed;"]`


### itimpfy_location_tooltip

#### Purpose
Generates HTML for tooltip in the map-locations post editor

#### Shortcode Parameters
- `address` - Address of location, all one line
- `cash` - Doesn't expect any specific values. For ex: `cash="true"` does the same as `cash="foo"`
- `check` - Doesn't expect any specific values. For ex: `check="true"` does the same as `check="foo"`

#### Shortcode Example
`[itimpfy_location_tooltip address="123 Main St." cash="true"]`

### itimpfy_location_short_description

#### Purpose
Generates HTML for main description (topmost text-input on map-locations post editor)

#### Shortcode Parameters
- `address` - Address of location, all one line, comma separated
- `hours` - Accepts hours (renders whatever format is input) separated by semicolons. A new line is made for each hours group between semicolons

#### Shortcode Example
`[itimpfy_location_short_description address="123 Main St." hours="Mon - Fri: 5am-4pm; Sat & Sun: Closed;"]`
