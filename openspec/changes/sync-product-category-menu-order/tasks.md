## 1. Consolidate category ordering

- [x] 1.1 Add a shared frontend category tree query on `Category` that loads parent, child, and grandchild categories in ascending `sort_order`.
- [x] 1.2 Refactor `NavigationController` to use the shared category tree query for the main menu dropdown.
- [x] 1.3 Refactor `ProductController::index()` and `ProductController::show()` to use the same shared category tree query for the left sidebar.

## 2. Verify frontend behavior

- [x] 2.1 Add feature or integration coverage asserting the main menu dropdown renders categories in admin-defined `sort_order`.
- [x] 2.2 Add feature or integration coverage asserting the product list/detail sidebar renders the same category order as the main menu dropdown.
- [x] 2.3 Run the targeted test suite and confirm no regression in frontend category navigation ordering.
