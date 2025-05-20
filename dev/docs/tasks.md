# Ovommand Improvement Tasks

This document contains a comprehensive list of actionable improvement tasks for the Ovommand project. Each task is marked with a checkbox that can be checked off when completed.

## Architecture and Design

1. [ ] Implement command namespace system as mentioned in the README (from vanilla addon: `/plugin1:test`)
2. [ ] Develop a solution for handling duplicate command names (adding counter to the command name)
3. [ ] Refactor the parameter system to make it more extensible and easier to add new parameter types
4. [ ] Move part of Ovommand functionality to BaseCommand as mentioned in the TODO list
5. [ ] Evaluate and implement attribute support for commands and parameters
6. [ ] Redesign the constraint system to be more flexible and support more use cases
7. [ ] Create a more robust system for handling command aliases (allow users to decide how subcommand aliases are handled)
8. [ ] Implement a proper dependency injection system for commands and parameters

## Code Quality and Standards

1. [x] Remove commented-out debug code in Ovommand.php (lines 248-256)
2. [x] Fix the `$returnRaw` property in BaseParameter which is noted as "confusing and useless"
3. [x] Implement the `isBlockPos` functionality in CoordinateResult which currently does nothing
4. [x] Standardize error handling across the codebase
5. [ ] Add proper type hints and return types to all methods
6. [ ] Ensure consistent coding style across all files
7. [ ] Refactor long methods (like parseParameters in Ovommand.php) into smaller, more focused methods
8. [ ] Fix broken SYNTAX_PRINT_VANILLA as mentioned in the TODO list

## Documentation

1. [ ] Complete the wiki documentation with comprehensive guides and examples
2. [ ] Add PHPDoc comments to all classes and methods
3. [ ] Create a getting started guide for new users
4. [ ] Document the parameter system thoroughly, including how to create custom parameters
5. [ ] Add examples for common use cases
6. [ ] Create diagrams showing the architecture and relationships between components
7. [ ] Document the constraint system and how to create custom constraints
8. [ ] Add inline documentation for complex algorithms and logic

## Testing

1. [ ] Implement a proper unit testing framework
2. [ ] Create tests for all parameter types
3. [ ] Add integration tests for command execution
4. [ ] Test edge cases for parameter parsing
5. [ ] Create tests for constraint validation
6. [ ] Implement automated testing in CI/CD pipeline
7. [ ] Add performance benchmarks for critical components
8. [ ] Create tests for error handling and recovery

## Performance Optimization

1. [ ] Optimize the parameter parsing algorithm
2. [ ] Reduce memory usage for large command hierarchies
3. [ ] Cache generated usage messages
4. [ ] Optimize the constraint validation process
5. [ ] Improve performance of regex-based parameter parsing
6. [ ] Benchmark and optimize the command execution flow
7. [ ] Implement lazy loading for command components where appropriate

## Feature Implementation

1. [ ] Complete the target parameter implementation (`@a`, `@s`, etc.)
2. [ ] Implement JSON parameter support
3. [ ] Add support for command namespaces
4. [ ] Implement the ability for subcommands to not require permissions if wanted
5. [ ] Fix the issue where parsing fails for parameters after position parameters with less than the span
6. [ ] Allow parameters to not provide data to the in-game auto-complete
7. [ ] Implement template support for commands
8. [ ] Add support for private enums and synced properties for soft enums

## Bug Fixes

1. [ ] Fix the issue where the parser cannot check the correct span leading to invalid inputs being accepted
2. [ ] Address the problem where parsing fails for parameters after position parameters with less than the span
3. [ ] Fix broken SYNTAX_PRINT_VANILLA
4. [ ] Resolve the issue with duplicate values in Default Enums if the event is called more than twice
5. [ ] Fix any issues with shared data when plugins try to use enums from other plugins (plugin loading order)
6. [ ] Address any memory leaks or performance bottlenecks
7. [ ] Fix edge cases in parameter parsing
8. [x] Fix bug in CoordinateResult.__toString() method where it incorrectly used $this->y instead of $this->yType

## Release and Deployment

1. [ ] Create a stable release version
2. [ ] Set up proper versioning system
3. [ ] Implement a changelog to track changes between versions
4. [ ] Create a release process document
5. [ ] Set up automated builds and releases
6. [ ] Implement a plugin update notification system
7. [ ] Create a compatibility matrix for different PocketMine-MP versions
8. [ ] Develop a migration guide for users upgrading from other command frameworks

## Community and Support

1. [ ] Set up a community forum or discussion platform
2. [ ] Create contribution guidelines
3. [ ] Implement a system for tracking and addressing user feedback
4. [ ] Develop a roadmap for future development
5. [ ] Create a code of conduct for contributors
6. [ ] Set up a system for reporting and tracking bugs
7. [ ] Develop a support process for users
8. [ ] Create templates for bug reports and feature requests
