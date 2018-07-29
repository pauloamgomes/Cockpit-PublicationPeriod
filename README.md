# Cockpit Publication Period

This addon extends Cockpit CMS core functionality by introducing the possibility to limit the collection entries based on an Publication Period field. Such field contains a starting and ending date value (both optional). If the values are set and they don't match the current date the collection entry is excluded from the default Cockpit API collections request.

## Installation

1.  Confirm that you have Cockpit CMS (Next branch) installed and working.
2.  Download zip and extract to 'your-cockpit-docroot/addons' (e.g. cockpitcms/addons/PublicationPeriod)
3.  Create or access an existing collection and confirm you have the PublicationPeriod field available.

## Configuration

The Addon doesn't require any extra configuration. When enabled, it will be available as a new field.

## Usage

The field doesn't require any extra configuration, just add it as any other field:

![PublicationPeriod](https://monosnap.com/image/MBvKbwn2oQryW3hWkpGZaeHUgttj0P.png)

When added to a collection the field will provide a starting and ending date:

![Field Usage](https://monosnap.com/image/ggAtmn2LtqQqD3UT56jOIxS9Al2M51.png)

## Copyright and license

Copyright 2018 pauloamgomes under the MIT license.
