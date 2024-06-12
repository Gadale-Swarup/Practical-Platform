// import { useState } from "react";
// import { Box, Button, Text, useToast } from "@chakra-ui/react";
// import { executeCode } from "../api";

// const Output = ({ editorRef, language }) => {
//   const toast = useToast();
//   const [output, setOutput] = useState(null);
//   const [isLoading, setIsLoading] = useState(false);
//   const [isError, setIsError] = useState(false);

//   const runCode = async () => {
//     const sourceCode = editorRef.current.getValue();
//     if (!sourceCode) return;
//     try {
//       setIsLoading(true);
//       const { run: result } = await executeCode(language, sourceCode);
//       setOutput(result.output.split("\n"));
//       result.stderr ? setIsError(true) : setIsError(false);
//     } catch (error) {
//       console.log(error);
//       toast({
//         title: "An error occurred.",
//         description: error.message || "Unable to run code",
//         status: "error",
//         duration: 6000,
//       });
//     } finally {
//       setIsLoading(false);
//     }
//   };

//   return (
//     <Box w="50%">
//       <Text mb={2} fontSize="lg">
//         Output
//       </Text>
//       <Button
//         variant="outline"
//         colorScheme="green"
//         mb={4}
//         isLoading={isLoading}
//         onClick={runCode}
//       >
//         Run Code
//       </Button>
//       <Box
//         height="75vh"
//         p={2}
//         color={isError ? "red.400" : ""}
//         border="1px solid"
//         borderRadius={4}
//         borderColor={isError ? "red.500" : "#333"}
//       >
//         {output
//           ? output.map((line, i) => <Text key={i}>{line}</Text>)
//           : 'Click "Run Code" to see the output here'}
//       </Box>
//     </Box>
//   );
// };
// export default Output;


import React, { useState } from "react";
import { Box, Button, Text, useToast } from "@chakra-ui/react";
import { executeCode } from "../api";
import { saveAs } from "file-saver"; // Import the saveAs function


const Output = ({ editorRef, language }) => {
  const toast = useToast();
  const [output, setOutput] = useState(null);
  const [customInput, setCustomInput] = useState(""); // Track custom input
  const [isLoading, setIsLoading] = useState(false);
  const [isError, setIsError] = useState(false);

  const runCode = async () => {
    const sourceCode = editorRef.current.getValue();
    if (!sourceCode) return;
    try {
      setIsLoading(true);
      const { run: result } = await executeCode(language, sourceCode);
      setOutput(result.output.split("\n"));
      setCustomInput(sourceCode); // Save the custom input
      result.stderr ? setIsError(true) : setIsError(false);
    } catch (error) {
      console.log(error);
      toast({
        title: "An error occurred.",
        description: error.message || "Unable to run code",
        status: "error",
        duration: 6000,
      });
    } finally {
      setIsLoading(false);
    }
  };

  const saveInputAndOutput = () => {
    // Combine input and output into a single string
    const combinedData = `Input:\n${customInput}\n\nOutput:\n${output.join("\n")}`;
    const blob = new Blob([combinedData], { type: "text/plain" });
    saveAs(blob, "input_output.txt");
  };

  return (
    <Box w="50%">
      <Text mb={2} fontSize="lg">
        Output
      </Text>
      <Button
        variant="outline"
        colorScheme="green"
        mb={4}
        isLoading={isLoading}
        onClick={runCode}
      >
        Run Code
      </Button>
      <Button
        variant="outline"
        colorScheme="purple"
        mb={4}
        onClick={saveInputAndOutput}
      >
        Save Input & Output
      </Button>
      <Box
        height="75vh"
        p={2}
        color={isError ? "red.400" : ""}
        border="1px solid"
        borderRadius={4}
        borderColor={isError ? "red.500" : "#333"}
      >
        {output
          ? output.map((line, i) => <Text key={i}>{line}</Text>)
          : 'Click "Run Code" to see the output here'}
      </Box>
    </Box>
  );
};

export default Output;
