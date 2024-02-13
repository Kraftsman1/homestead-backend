# Changelog

## 2024-02-13

### Added

- Added a search suggestions endpoint to return matches based on keywords to the frontend
- Added Home controller to handle all future endpoints for the homepage
- Added Search filter to filter destinations by city, region or country. More filters can be added as needed

## Removed

- Search filter from destinations endpoint.

## Fixed

- Query parameters for web and json body for mobile

## 2024-01-05

### Added

- Get Destinations endpoint
- Search filter
- Paginated records
- Destination Amenities
- Favorite/Unfavorite a Destination
- Get all User Favorites

### Fixed

- Destination model relations

## 2023-12-18

### Added

- Set up API auth using Sanctum

### Fixed

- Issue with Laravel returning home route on failed validation
