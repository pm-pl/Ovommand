/**
 * Registers an overload for the "changesetting" command with specific parameter configurations.
 * This function handles the registration process including memory management and parameter setup.
 *
 * @param registry          Pointer to the CommandRegistry instance where the overload will be registered
 * @param unused           Unused parameter (reserved)
 * @param commandVersion   Version information or context for the command
 * @param parameterData    Pointer to the array of CommandParameterData for command execution
 * @param additionalConfig Additional configuration data for the overload
 */
void __fastcall CommandRegistry::registerOverload<ChangeSettingCommand, CommandParameterData, CommandParameterData>(
    CommandRegistry* registry,
    __int64 unused,
    __int64 commandVersion,
    __int64 parameterData,
    __int64 additionalConfig
) {
    // Constants for memory management
    constexpr size_t COMMAND_NAME_LENGTH = 0xD;
    constexpr size_t OVERLOAD_STRUCT_SIZE = 48LL;
    constexpr size_t PARAMETER_DATA_SIZE = 80;
    constexpr size_t MIN_PARAMETER_SLOTS = 2;

    // Local variables for command registration
    struct CommandRegistry::Signature* commandSignature;
    __int64 allocatedConfig = additionalConfig;
    void* stringBuffer;
    __int64 overloadPtr;
    __int64 overloadMetadata;
    __int64 parameterSpace;
    __int64 (__fastcall *commandAllocator)() = nullptr;
    void* stringData[2];
    __m128i vectorData = _mm_load_si128((const __m128i*)&_xmm);
    __int64 savedVersion = commandVersion;

    // Initialize command name string
    LOBYTE(stringData[0]) = 0;
    std::string::assign(stringData, "changesetting", COMMAND_NAME_LENGTH);

    // Look up the command signature in the registry
    commandSignature = (struct CommandRegistry::Signature*)CommandRegistry::findCommand(registry, stringData);

    // Clean up string memory if necessary
    if (vectorData.m128i_i64[1] >= 0x10uLL) {
        size_t allocSize = vectorData.m128i_i64[1] + 1;
        stringBuffer = stringData[0];

        if (allocSize >= 0x1000) {
            allocSize = vectorData.m128i_i64[1] + 40;
            stringBuffer = (void*)*((_QWORD*)stringData[0] - 1);

            if ((unsigned __int64)((char*)stringData[0] - (char*)stringBuffer - 8) > 0x1F) {
                _invalid_parameter_noinfo_noreturn();
            }
        }
        operator delete(stringBuffer, allocSize);
    }

    // Process command registration if signature exists
    if (commandSignature) {
        // Set up command allocator
        commandAllocator = CommandRegistry::allocateCommand<ChangeSettingCommand>;

        // Handle overload storage
        overloadPtr = *((_QWORD*)commandSignature + 9);
        if (*((_QWORD*)commandSignature + 10) == overloadPtr) {
            // Reallocate space for new overload
            std::vector<CommandRegistry::Overload>::_Emplace_reallocate<CommandVersion&, std::unique_ptr<Command>(*)(void)>(
                (char*)commandSignature + 64,
                overloadPtr,
                &savedVersion,
                &commandAllocator
            );
        } else {
            // Initialize new overload in existing space
            *(_QWORD*)overloadPtr = commandVersion;
            *(_QWORD*)(overloadPtr + 8) = CommandRegistry::allocateCommand<ChangeSettingCommand>;
            *(_QWORD*)(overloadPtr + 16) = 0LL;
            *(_QWORD*)(overloadPtr + 24) = 0LL;
            *(_QWORD*)(overloadPtr + 32) = 0LL;
            *(_DWORD*)(overloadPtr + 40) = -1;
            *((_QWORD*)commandSignature + 9) += OVERLOAD_STRUCT_SIZE;
        }

        // Ensure sufficient parameter space
        overloadMetadata = *((_QWORD*)commandSignature + 9);
        parameterSpace = *(_QWORD*)(overloadMetadata - 16) - *(_QWORD*)(overloadMetadata - 32);

        if ((unsigned __int64)(parameterSpace / PARAMETER_DATA_SIZE) < MIN_PARAMETER_SLOTS) {
            std::vector<CommandParameterData>::_Reallocate_exactly(
                overloadMetadata - 32,
                MIN_PARAMETER_SLOTS
            );
        }

        // Build and register the overload
        CommandRegistry::buildOverload<CommandParameterData>(
            parameterSpace,
            overloadMetadata - OVERLOAD_STRUCT_SIZE,
            parameterData,
            allocatedConfig,
            commandAllocator
        );

        // Register the overload internally
        CommandRegistry::registerOverloadInternal(
            registry,
            commandSignature,
            (struct CommandRegistry::Overload*)(overloadMetadata - OVERLOAD_STRUCT_SIZE)
        );
    }
}