# Ability-Role Spec

## Abilities
* view_any_cases
* create_case
* triage_case
* exam_case
* procedure_case
* discharge_case
* cancel_case

## Roles
* officer
    - view_any_cases
    - create_case
    - cancel_case

* nurse
    - view_any_cases
    - triage_case
    - discharge_case

* gp_md
    - view_any_cases
    - exam_case

* er_md
    - view_any_cases
    - exam_case
    - procedure_case