/**
 * Resolves and retrieves enum data from the CommandRegistry using binary search.
 *
 * This function performs a lookup operation to find enum data based on the provided parse token.
 * It uses a binary search algorithm to efficiently locate the matching enum value in the registry's
 * internal mapping table.
 *
 * @param this         Pointer to the current CommandRegistry instance that contains the enum mappings
 * @param parseToken   Pointer to a ParseToken structure containing the token information needed for enum resolution
 *
 * @return The resolved enum value associated with the parse token
 */
unsigned __int64 __fastcall CommandRegistry::getEnumData(
    CommandRegistry* this,
    const struct CommandRegistry::ParseToken* parseToken
) {
    // Extract the masked value from the parse token
    // This value serves as the search key for finding the matching enum
    unsigned __int64 maskedTokenValue =
        *(int*)(*(_QWORD*)parseToken + 36LL) & 0xFFFFFFFFF80FFFFFuLL;

    // Calculate the index into the mapping table
    // The index is derived from another masked token field multiplied by 9
    unsigned __int64 mappingTableIndex =
        9 * (*((int*)parseToken + 9) & 0xFFFFFFFFF80FFFFFuLL);

    // Get the base pointer to the enum mapping table
    __int64 mappingTableBase = *((_QWORD*)this + 27);

    // Initialize binary search boundaries
    __int64 searchRangeStart = *(_QWORD*)(mappingTableBase + 8 * mappingTableIndex + 48);
    __int64 elementsInRange = (*(_QWORD*)(mappingTableBase + 8 * mappingTableIndex + 56) - searchRangeStart) >> 4;

    // Perform binary search to find the matching enum value
    while (elementsInRange > 0) {
        // Calculate the middle element index
        __int64 midPoint = elementsInRange >> 1;
        __int64 midElementValue = *(_QWORD*)(searchRangeStart + 16 * midPoint);

        if (midElementValue >= maskedTokenValue) {
            // Search in the lower half if middle value is greater or equal
            elementsInRange = midPoint;
        } else {
            // Search in the upper half if middle value is smaller
            // Move start pointer past the middle element
            searchRangeStart += 16 * midPoint + 16;
            // Adjust remaining range size
            elementsInRange = elementsInRange - 1 - midPoint;
        }
    }

    // Return the found enum value, stored 8 bytes offset from the final position
    return *(_QWORD*)(searchRangeStart + 8);
}