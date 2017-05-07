FREAD

#include <stdio.h>
#include <errno.h>
int main(int argc, char *argv[]) {
	FILE *fp;
	/*struct student {
		char name[16];
		int age;
	}s; */
	int arr[4];
	if(argc != 2) {
		printf("usage:./fread filename");
		return EINVAL;
	}
	fp = fopen(argv[1], "r");
	if(fp == NULL) {
		perror("fread");
		return errno;
	}
	/*fread(&s, sizeof(s), 1, fp);
	printf("%s %d\n", s.name, s.age);*/
	fread(arr, sizeof(int), 4, fp);
	printf("%d %d %d %d\n", arr[0], arr[1], arr[2], arr[3]);
	fclose(fp);
	return 0;
}

FWRITE

#include <stdio.h>
#include <errno.h>
int main(int argc, char *argv[]) {
	FILE *fp;
	/*struct student {
		char name[16];
		int age;
	}s; */
	int arr[4];
	if(argc != 2) {
		printf("usage:./fread filename\n");
		return EINVAL;
	}
	fp = fopen(argv[1], "w");
	if(fp == NULL) {
		perror("fread");
		return errno;
	}
	/*scanf("%s%d", s.name, &s.age);*/
	scanf("%d%d%d%d", &arr[0], &arr[1], &arr[2], &arr[3]);
	fwrite(arr, sizeof(int), 4, fp);
	fclose(fp);
	return 0;
}

READ

#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <stdio.h>
int main(int argc, char *argv[]) {
	int fd, count, i;
	char buf[512];
	fd = open(argv[1], O_RDONLY);
	if(fd == -1) {
		printf("Bad filename\n");
		return 10;
	}	
	/* sure that fd refers to the file argv[1] */
	while((count = read(fd, buf , 512)) != 0)
		for(i = 0; i < count; i++)
			putchar(buf[i]);	
	close(fd);
}

WRITE

#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <stdio.h>
#include <string.h>
#include <errno.h>
int main(int argc, char *argv[]) {
	int fd, count, i;
	char buf[512];
	fd = open(argv[1], O_CREAT | O_WRONLY, S_IRWXU);
	if(fd == -1) {
		/*printf("Errno = %d \n", errno);*/
		perror("write: ");
		return errno;
	}	
	scanf("%s", buf);
	write(fd, buf, strlen(buf));
	close(fd);
}
