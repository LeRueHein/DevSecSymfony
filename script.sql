CREATE DATABASE [DevSecSymfony]

USE [DevSecSymfony]
GO
CREATE TABLE [dbo].[message](
    [id] [int] IDENTITY(1,1) NOT NULL,
    [date] [datetime2](6) NULL,
    [content] [nvarchar](4000) NULL,
    [users_id] [int] NOT NULL)

CREATE TABLE [dbo].[messenger_messages](
    [id] [bigint] IDENTITY(1,1) NOT NULL,
    [body] [varchar](max) NOT NULL,
    [headers] [varchar](max) NOT NULL,
    [queue_name] [nvarchar](190) NOT NULL,
    [created_at] [datetime2](6) NOT NULL,
    [available_at] [datetime2](6) NOT NULL,
    [delivered_at] [datetime2](6) NULL)


CREATE TABLE [dbo].[user](
    [id] [int] IDENTITY(1,1) NOT NULL,
    [email] [nvarchar](180) NOT NULL,
    [roles] [varchar](max) NOT NULL,
    [password] [nvarchar](255) NOT NULL,
    [token] [nvarchar](255) NULL,
    [date_expiration_token] [datetime2](6) NULL);


