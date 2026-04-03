## ADDED Requirements

### Requirement: Frontend product category navigation uses admin-defined sort order
The system SHALL render product categories in every frontend navigation entry using the admin-defined `sort_order` sequence. This requirement applies to top-level categories and all displayed descendant categories.

#### Scenario: Main menu dropdown follows category sort order
- **WHEN** a shopper opens the frontend product category dropdown
- **THEN** the dropdown SHALL list top-level categories in ascending `sort_order`
- **AND** each nested category list SHALL also be rendered in ascending `sort_order`

#### Scenario: Product page sidebar follows the same category sort order
- **WHEN** a shopper views a product listing page or product detail page with the category sidebar
- **THEN** the sidebar SHALL list the same categories in the same ascending `sort_order` sequence as the main menu dropdown
- **AND** nested categories SHALL preserve ascending `sort_order` within each parent

### Requirement: Frontend category navigation shares a single ordering source
The system SHALL use one shared category tree retrieval rule for frontend product navigation so that all product category navigation surfaces stay consistent after backoffice sorting changes.

#### Scenario: Admin updates category sort order
- **WHEN** an administrator changes a category's `sort_order` in the backoffice
- **THEN** the next frontend render of the main menu dropdown SHALL reflect the updated sequence
- **AND** the next frontend render of the product page sidebar SHALL reflect the same updated sequence

#### Scenario: New frontend navigation surface is added
- **WHEN** developers introduce another frontend product category navigation surface
- **THEN** that surface MUST consume the same shared category ordering rule
- **AND** it MUST NOT define an independent ordering implementation that can diverge from existing navigation surfaces
