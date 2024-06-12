import { useRef, useState } from "react";
import { Box, HStack, Input } from "@chakra-ui/react";
import { Editor } from "@monaco-editor/react";
import LanguageSelector from "./LanguageSelector";
import { CODE_SNIPPETS } from "../constants";
import Output from "./Output";

const CodeEditor = () => {
  const editorRef = useRef();
  const [value, setValue] = useState("");
  const [language, setLanguage] = useState("javascript");
  const [inputValue, setInputValue] = useState(""); // State for input value
  const [output, setOutput] = useState(""); // State for output value

  const onMount = (editor) => {
    editorRef.current = editor;
    editor.focus();
  };

  const onSelect = (language) => {
    setLanguage(language);
    setValue(CODE_SNIPPETS[language]);
  };

  const handleInputChange = (event) => {
    setInputValue(event.target.value);
  };

  const handleRunCode = () => {
    // Here you can run your code with the input value
    // For demonstration, let's just set the output to the input value
    setOutput(inputValue);
  };

  return (
    <Box>
      <HStack spacing={4}>
        <Box w="50%">
          <LanguageSelector language={language} onSelect={onSelect} />
          <Editor
            options={{
              minimap: {
                enabled: false,
              },
            }}
            height="50vh" // Adjust height as needed
            theme="vs-dark"
            language={language}
            defaultValue={CODE_SNIPPETS[language]}
            onMount={onMount}
            value={value}
            onChange={(value) => setValue(value)}
          />
          <Input
            value={inputValue}
            onChange={handleInputChange}
            placeholder="Enter input"
            mt={4}/>
         
        </Box>
        <Output editorRef={editorRef} language={language} output={output} />
      </HStack>
    </Box>
  );
};
export default CodeEditor;
