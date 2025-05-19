/**
 * Builds a command overload by adding two CommandParameterData instances to a vector.
 *
 * This function manages the addition of two command parameters to a vector, handling
 * memory reallocation when necessary. It ensures proper vector growth and element construction.
 *
 * @param registry          Unused registry context parameter
 * @param overloadVector   Pointer to the vector structure managing CommandParameterData elements
 * @param primaryParam     First CommandParameterData to be added to the vector
 * @param secondaryParam   Second CommandParameterData to be added to the vector
 *
 * @return Pointer to the last inserted CommandParameterData instance
 */
CommandParameterData* __fastcall CommandRegistry::buildOverload<CommandParameterData>(
    __int64 registry,
    __int64 overloadVector,
    const struct CommandParameterData* primaryParam,
    const struct CommandParameterData* secondaryParam
) {
    // Get vector management pointers
    CommandParameterData* currentEnd = *(CommandParameterData**)(overloadVector + 24);
    __int64 vectorMetadata = overloadVector + 16;
    CommandParameterData* result;

    // Size constants
    constexpr __int64 PARAMETER_DATA_SIZE = 80LL; // Size of CommandParameterData in bytes

    // Add the primary parameter
    if (*(CommandParameterData**)(overloadVector + 32) == currentEnd) {
        // Vector is full, need to reallocate before adding primaryParam
        std::vector<CommandParameterData>::_Emplace_reallocate<CommandParameterData const&>(
            vectorMetadata,
            *(CommandParameterData**)(overloadVector + 24),
            primaryParam
        );
    } else {
        // Vector has space, construct primaryParam at current position
        CommandParameterData::CommandParameterData(currentEnd, primaryParam);

        // Advance the end pointer
        *(_QWORD*)(vectorMetadata + 8) += PARAMETER_DATA_SIZE;
    }

    // Add the secondary parameter
    if (*(_QWORD*)(vectorMetadata + 16) == *(_QWORD*)(vectorMetadata + 8)) {
        // Vector is full again, reallocate and add secondaryParam
        return (CommandParameterData*)std::vector<CommandParameterData>::_Emplace_reallocate<CommandParameterData const&>(
            vectorMetadata,
            *(_QWORD*)(vectorMetadata + 8),
            secondaryParam
        );
    }

    // Vector has space for secondaryParam
    result = CommandParameterData::CommandParameterData(
        *(CommandParameterData**)(vectorMetadata + 8),
        secondaryParam
    );

    // Advance the end pointer
    *(_QWORD*)(vectorMetadata + 8) += PARAMETER_DATA_SIZE;

    return result;
}