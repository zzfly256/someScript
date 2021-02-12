package main

import (
	"fmt"
	"os"
	"os/exec"
	"strconv"
	"sync"
)

func ExecCommand(command ...string) {
	defer func() {
		err := recover()
		if err != nil {
			fmt.Println("执行异常：", command, " ", err)
		}
	}()

	cmd := exec.Command("/usr/bin/env", command...)
	cmd.Stdout = os.Stdout
	err := cmd.Run()
	if err != nil {
		panic(err)
	}
}

func main() {
	args := os.Args

	if len(args) < 3  {
		fmt.Println("参数错误，参数 1 为并发数，参数 2 往后为 shell 命令")
		os.Exit(-1)
	}

	processNum, err := strconv.Atoi(args[1])

	if err != nil {
		println("参数错误，参数 1 需要为整数")
		os.Exit(-1)
	}

	if processNum < 1 {
		println("参数错误，参数 1 需要大于等于 1")
		os.Exit(-1)
	}

	command := args[2:]

	wg := sync.WaitGroup{}

	for i := 0; i < processNum; i++ {
		wg.Add(1)
		go func() {
			ExecCommand(command...)
			wg.Done()
		}()
	}

	wg.Wait()

}
