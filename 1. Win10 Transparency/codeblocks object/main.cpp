#include <iostream>
#include <cstdio>
#include <windows.h>
#include <io.h>
using namespace std;

int main()
{
    system("title Win10 Transparency");
    system("color f0&&mode con cols=75 lines=20");
    cout << " ��ӭʹ�� Win10Transparency" <<endl;
    cout << " --------------------------------------------" << endl<<endl;
    cout << " �����߿���ʹ Windows 10 ����������ø���͸���������󷽡�" <<endl;
    cout << " ������������΢��һ�����صĿ��أ�ʹ��֮������ļ����ϵͳ���κθ����á�" <<endl<<endl;
    cout <<endl << " �밴���������ʼ���� " << endl;
    getchar();

    cout << " ������ʼ " << endl;
    cout <<endl << " 1) ��������ע���б��ļ� " << endl;
    FILE *fp;
    if((fp=fopen("output.reg","w"))==NULL)
    {
        system("color fc");
        cout << " 1) ����ʧ�ܣ������Ƿ�ʹ�ù���ԱȨ������ " << endl;
        getchar();
    }
    else
    {
        fprintf(fp,"%s","Windows Registry Editor Version 5.00\n\n");
        fprintf(fp,"%s","[HKEY_LOCAL_MACHINE\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Explorer\\Advanced]\n");
        fprintf(fp,"%s","\"UseOLEDTaskbarTransparency\"=dword:00000001");
        fclose(fp);
        cout << " 1) ����ע���б��ļ��ɹ� " << endl;
    }
    Sleep(1000);
    cout << " 2) ����Windowsע���б�    ";
    Sleep(1000);
    system("regedit.exe /s output.reg");
    cout << " 3) �����߻��� " << endl;
    system("del output.reg");
    Sleep(1000);
    cout << " 4) ���� explorer.exe ���� " << endl;
    system("start taskkill /im explorer.exe /f");
    Sleep(1500);
    system("start c:\\windows\\explorer.exe");
    cout <<endl<< " ������ϣ��������á�\n by Rytia" << endl;
    getchar();
    return 0;
}
